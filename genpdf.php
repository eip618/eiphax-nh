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

    // Page header
    function Header() {
        // Header strip background
        $this->SetFillColor(76, 107, 154);
        $this->Rect(0, 0, $this->GetPageWidth(), 20, 'F');
        // Logo
        if (!empty($this->headerData['logo']) && file_exists($this->headerData['logo'])) {
            $this->Image($this->headerData['logo'], 10, 3, 14);
        }
        // Title
        $this->SetFont('Times', 'B', 16);
        $this->SetTextColor(224, 240, 255);
        $this->Cell(0, 10, $this->headerData['title'], 0, 0, 'C');
        // Document type
        $this->SetFont('Times', '', 12);
        $this->SetXY(-60, 3);
        $this->Cell(50, 10, 'Document: ' . $this->headerData['doctype'], 0, 0, 'R');
        $this->Ln(20);
    }

    // Page footer
    function Footer() {
        $this->SetY(-15);
        // Footer background
        $this->SetFillColor(42, 62, 95);
        $this->Rect(0, $this->GetPageHeight() - 15, $this->GetPageWidth(), 15, 'F');
        // Footer text
        $this->SetFont('Times', 'I', 10);
        $this->SetTextColor(224, 240, 255);
        $this->Cell(0, 10, $this->footerData['userName'] . ' - Page ' . $this->PageNo(), 0, 0, 'R');
    }
}

function processMarkdown($content, $pdf) {
    // Auto page breaks with 30pt bottom margin
    $pdf->SetAutoPageBreak(true, 30);
    // Compute content area
    $contentWidth = $pdf->GetPageWidth() * 0.8;
    $margin = ($pdf->GetPageWidth() - $contentWidth) / 2;
    $pdf->SetMargins($margin, 30, $margin);
    $pdf->SetFont('Times', '', 12);
    $pdf->SetTextColor(224, 240, 255);

    $lines = preg_split('/\r\n|\r|\n/', $content);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            // Blank line
            $pdf->Ln(10);
            continue;
        }
        if (preg_match('/^# (.+)/', $line, $m)) {
            $pdf->SetFont('Times', 'B', 20);
            $pdf->MultiCell(0, 10, $m[1], 0, 'C');
        } elseif (preg_match('/^## (.+)/', $line, $m)) {
            $pdf->SetFont('Times', 'B', 16);
            $pdf->MultiCell(0, 10, $m[1], 0, 'C');
        } elseif (preg_match('/^- (.+)/', $line, $m)) {
            $pdf->SetFont('Times', 'I', 12);
            $pdf->MultiCell(0, 10, '• ' . $m[1], 0, 'L');
        } else {
            $pdf->SetFont('Times', '', 12);
            $pdf->MultiCell(0, 10, $line, 0, 'C');
        }
        // reset font and color
        $pdf->SetFont('Times', '', 12);
        $pdf->SetTextColor(224, 240, 255);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['userName'] ?? '';
    $doctype = $_POST['doctype'] ?? '';
    $content = $_POST['content'] ?? '';

    $pdf = new PDF();
    $pdf->setHeaderData([
        'logo' => 'nhlogo.png',
        'title' => 'Nintendo Homebrew',
        'doctype' => $doctype
    ]);
    $pdf->setFooterData([
        'userName' => $userName
    ]);

    $pdf->AddPage();
    processMarkdown($content, $pdf);
    $pdf->Output('D', 'document.pdf');
    exit;
}
