<?php
require('fpdf/fpdf.php');

class PDF extends FPDF {
    private $headerData = ['logo'=>'','title'=>'','doctype'=>''];
    private $footerData = ['userName'=>''];

    public function setHeaderData($data) {
        $this->headerData = array_merge($this->headerData, $data);
    }

    public function setFooterData($data) {
        $this->footerData = array_merge($this->footerData, $data);
    }

    // Page header: full-page background + header strip with proper vertical centering
    function Header() {
        $pageW = $this->GetPageWidth();
        $pageH = $this->GetPageHeight();
        $headerH = 40; // header strip height in user units

        // Full-page background
        $this->SetFillColor(42, 62, 95);
        $this->Rect(0, 0, $pageW, $pageH, 'F');

        // Header strip background
        $this->SetFillColor(76, 107, 154);
        $this->Rect(0, 0, $pageW, $headerH, 'F');

        // Vertical center of header strip
        $yCenter = $headerH / 2;

        // Logo dimensions
        $imgW = 14;
        $imgH = 14;
        $xImg = 10;
        $yImg = $yCenter - ($imgH / 2);
        if (!empty($this->headerData['logo']) && file_exists($this->headerData['logo'])) {
            $this->Image($this->headerData['logo'], $xImg, $yImg, $imgW, $imgH);
        }

        // Title
        $fontTitle = 18;
        $this->SetFont('Times', 'B', $fontTitle);
        $this->SetTextColor(224, 240, 255);
        // Compute title vertical position to center text block
        $titleHeight = $this->FontSize; // cell height = current font size user unit
        $this->SetXY(0, $yCenter - ($titleHeight / 2));
        $this->Cell($pageW, $titleHeight, $this->headerData['title'], 0, 0, 'C');

        // Document type (single line, right-aligned)
        $this->SetFont('Times', '', 12);
        $docText = 'Document: ' . $this->headerData['doctype'];
        $docHeight = $this->FontSize;
        $this->SetXY($pageW - 10 - $this->GetStringWidth($docText), $yCenter - ($docHeight / 2));
        $this->Cell($this->GetStringWidth($docText), $docHeight, $docText, 0, 0, 'R');

        // Move cursor below header strip
        $this->Ln($headerH);
    }

    // Page footer
    function Footer() {
        $pageW    = $this->GetPageWidth();
        $pageH    = $this->GetPageHeight();
        $footerH  = 15;
        // Background strip
        $this->SetFillColor(42, 62, 95);
        $this->Rect(0, $pageH - $footerH, $pageW, $footerH, 'F');

        // Compute content margins (same as body)
        $contentWidth = $pageW * 0.8;
        $marginLR     = ($pageW - $contentWidth) / 2;

        // Footer text
        $footerY   = $pageH - 10;           // 10pt up from bottom
        $this->SetFont('Times','I',10);
        $this->SetTextColor(224,240,255);
        $this->SetXY($marginLR, $footerY);
        $footerText = $this->footerData['userName'] . ' - Page ' . $this->PageNo();
        // Constrain within contentWidth, right‑align
        $this->Cell($contentWidth, 10, $footerText, 0, 0, 'R');
    }
}

// Inline markdown parser (unchanged)
function parseInline($text) {
    $patterns = [
        ['pattern' => '/\*\*(.+?)\*\*/s', 'style' => ['Times','B',12]],
        ['pattern' => '/__(.+?)__/s',       'style' => ['Times','U',12]],
        ['pattern' => '/~~(.+?)~~/s',       'style' => ['Times','',12,'S']],
        ['pattern' => '/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/s', 'style' => ['Times','I',12]],
    ];
    $segments = [];
    while ($text !== '') {
        $bestPos = null; $bestMatch = null; $bestPattern = null;
        foreach ($patterns as $p) {
            if (preg_match($p['pattern'], $text, $m, PREG_OFFSET_CAPTURE)) {
                if ($bestPos === null || $m[0][1] < $bestPos) {
                    $bestPos = $m[0][1];
                    $bestMatch = $m;
                    $bestPattern = $p;
                }
            }
        }
        if ($bestPos === null) {
            $segments[] = ['text'=>$text,'style'=>['Times','',12]];
            break;
        }
        if ($bestPos > 0) {
            $segments[] = ['text'=>substr($text,0,$bestPos),'style'=>['Times','',12]];
        }
        $segments[] = ['text'=>$bestMatch[1][0],'style'=>$bestPattern['style']];
        $text = substr($text, $bestPos + strlen($bestMatch[0][0]));
    }
    return $segments;
}

function processMarkdown($content, $pdf) {
    $pdf->SetAutoPageBreak(true, 30);
    $contentWidth = $pdf->GetPageWidth() * 0.8;
    $marginLR = ($pdf->GetPageWidth() - $contentWidth) / 2;
    $pdf->SetLeftMargin($marginLR);
    $pdf->SetRightMargin($marginLR);

    $lineHeight = 10;
    $lines = preg_split('/\r\n|\r|\n/', $content);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            $pdf->Ln($lineHeight);
            continue;
        }
        if (strpos($line,'# ')===0) {
            $pdf->SetFont('Times','B',20);
            $pdf->SetTextColor(224,240,255);
            $pdf->MultiCell(0,$lineHeight,substr($line,2),0,'C');
        } elseif (strpos($line,'## ')===0) {
            $pdf->SetFont('Times','B',16);
            $pdf->SetTextColor(224,240,255);
            $pdf->MultiCell(0,$lineHeight,substr($line,3),0,'C');
        } elseif (strpos($line,'- ')===0) {
            $pdf->SetFont('Times','I',12);
            $pdf->SetTextColor(224,240,255);
            $pdf->Cell(5,$lineHeight,'•',0,0);
            $pdf->MultiCell(0,$lineHeight,substr($line,2),0,'L');
        } else {
            $segments = parseInline($line);
            foreach ($segments as $seg) {
                list($font,$style,$size) = $seg['style'];
                $pdf->SetFont($font,$style,$size);
                $pdf->SetTextColor(224,240,255);
                $pdf->Write($lineHeight, $seg['text']);
            }
            $pdf->Ln($lineHeight);
        }
    }
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $userName = $_POST['userName'] ?? '';
    $doctype  = $_POST['doctype']  ?? '';
    $content  = $_POST['content']  ?? '';

    $pdf = new PDF();
    $pdf->setHeaderData([
        'logo'=>'nhlogo.png','title'=>'Nintendo Homebrew','doctype'=>$doctype
    ]);
    $pdf->setFooterData(['userName'=>$userName]);

    $pdf->AddPage();
    processMarkdown($content,$pdf);
    $pdf->Output('D','document.pdf');
    exit;
}
