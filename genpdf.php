<?php
require('fpdf/fpdf.php');

class PDF extends FPDF {
    private $headerData;
    private $footerData;

    public function setHeaderData($data) {
        $this->headerData = $data;
    }

    public function setFooterData($data) {
        $this->footerData = $data;
    }

    function Header() {
        // Apply background color
        $this->SetFillColor(42, 62, 95); // Dark blue
        $this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F');

        // Add header section background
        $this->SetFillColor(76, 107, 154); // Lighter blue
        $this->Rect(0, 0, $this->GetPageWidth(), 20, 'F');

        // Add logo
        if (!empty($this->headerData['logo']) && file_exists($this->headerData['logo'])) {
            $this->Image($this->headerData['logo'], 10, 5, 10);
        }

        // Add title
        $this->SetTextColor(224, 240, 255); // Light text color
        $this->SetFont('Times', 'B', 16);
        $this->SetXY(25, 6);
        $this->Cell(0, 10, $this->headerData['title'], 0, 1, 'L');

        // Add document type
        $this->SetFont('Times', '', 12);
        $this->SetXY(-60, 6);
        $this->Cell(50, 10, 'Document: ' . $this->headerData['doctype'], 0, 1, 'R');

        // Set the Y position after header
        $this->SetY(25); // Important: This ensures content starts below header
    }

    function Footer() {
        // Footer background
        $this->SetFillColor(42, 62, 95);
        $this->Rect(0, $this->GetPageHeight() - 20, $this->GetPageWidth(), 20, 'F');

        // Footer text
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 10);
        $this->SetTextColor(224, 240, 255);
        $this->Cell(0, 10, $this->footerData['userName'] . ' - Page ' . $this->PageNo(), 0, 0, 'R');
    }
}

function processMarkdown($content, $pdf) {
    $lines = explode("\n", $content);
    $contentWidth = $pdf->GetPageWidth() * 0.8;
    $leftMargin = ($pdf->GetPageWidth() - $contentWidth) / 2;
    $lineHeight = 10;
    
    // Start at current Y position (set by Header())
    $y = $pdf->GetY();
    
    // Ensure light blue text color for all content
    $pdf->SetTextColor(224, 240, 255);

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // Check if page break needed
        if ($y > $pdf->GetPageHeight() - 30) {
            $pdf->AddPage();
            // Y position is now set by Header()
            $y = $pdf->GetY();
            // Ensure text color is maintained after page break
            $pdf->SetTextColor(224, 240, 255);
        }

        $pdf->SetXY($leftMargin, $y);

        if (preg_match('/^# (.+)/', $line, $matches)) {
            $pdf->SetFont('Times', 'B', 20);
            $pdf->MultiCell($contentWidth, $lineHeight, $matches[1], 0, 'C');
            $y += $lineHeight * 2; // Extra space after headers
        } elseif (preg_match('/^## (.+)/', $line, $matches)) {
            $pdf->SetFont('Times', 'B', 16);
            $pdf->MultiCell($contentWidth, $lineHeight, $matches[1], 0, 'C');
            $y += $lineHeight * 1.5; // Extra space after subheaders
        } elseif (preg_match('/^- (.+)/', $line, $matches)) {
            $pdf->SetFont('Times', 'I', 12);
            $pdf->SetX($leftMargin + 5); // Indent bullet points
            $pdf->Cell(5, $lineHeight, '•', 0, 0, 'L');
            $pdf->MultiCell($contentWidth - 10, $lineHeight, $matches[1], 0, 'L');
            $y += $lineHeight;
        } elseif (preg_match('/\*\*(.+)\*\*/', $line, $matches)) {
            $pdf->SetFont('Times', 'B', 12);
            $pdf->MultiCell($contentWidth, $lineHeight, $matches[1], 0, 'L');
            $y += $lineHeight;
        } elseif (preg_match('/\*(.+)\*/', $line, $matches)) {
            $pdf->SetFont('Times', 'I', 12);
            $pdf->MultiCell($contentWidth, $lineHeight, $matches[1], 0, 'L');
            $y += $lineHeight;
        } elseif (preg_match('/__(.+)__/', $line, $matches)) {
            $pdf->SetFont('Times', 'U', 12);
            $pdf->MultiCell($contentWidth, $lineHeight, $matches[1], 0, 'L');
            $y += $lineHeight;
        } elseif (preg_match('/~~(.+)~~/', $line, $matches)) {
            $pdf->SetFont('Times', '', 12);
            $pdf->MultiCell($contentWidth, $lineHeight, $matches[1], 0, 'L');
            $y += $lineHeight;
        } else {
            $pdf->SetFont('Times', '', 12);
            $pdf->MultiCell($contentWidth, $lineHeight, $line, 0, 'L');
            $y += $lineHeight;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = isset($_POST['userName']) ? htmlspecialchars($_POST['userName']) : 'Default User';
    $doctype = isset($_POST['doctype']) ? htmlspecialchars($_POST['doctype']) : 'Default Document';
    $content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : 'Default content for the PDF.';

    $pdf = new PDF();
    $pdf->setHeaderData([
        'logo' => 'nhlogo.png',
        'title' => 'Nintendo Homebrew',
        'doctype' => $doctype,
    ]);
    $pdf->setFooterData([
        'userName' => $userName,
    ]);

    $pdf->AddPage();
    processMarkdown($content, $pdf);
    $pdf->Output('D', 'document.pdf');
    exit;
}