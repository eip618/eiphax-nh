function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Page settings
    const pageHeight = doc.internal.pageSize.height;
    const pageWidth = doc.internal.pageSize.width;
    const contentWidth = pageWidth * 0.8; // 80% of page width
    const contentStartY = 60; // Starting Y position for content
    const contentEndY = pageHeight - 30; // Leave room for footer
    const lineHeight = 10; // Space between lines
    let y = contentStartY; // Initial Y position for content

    // Get input values
    const userName = document.getElementById("userName").value;
    const doctype = document.getElementById("doctype").value;
    const content = document.getElementById("content").value;

    if (!userName || !content || !doctype) {
        alert("Please fill in all fields.");
        return;
    }

    const img = new Image();
    img.src = "nhlogo.png"; // Ensure the logo file exists

    img.onload = function () {
        // Start rendering
        applyBackground(doc, pageWidth, pageHeight); // Add background to page
        addHeaderFooter(doc, img, userName, doctype, pageWidth, pageHeight, 1); // Add header and footer

        const processedContent = parseMarkdown(content, doc, contentWidth); // Process and wrap content

        let pageCount = 1;

        for (const line of processedContent) {
            if (y + lineHeight > contentEndY) {
                // Add new page
                doc.addPage();
                pageCount++;
                applyBackground(doc, pageWidth, pageHeight); // Add background
                addHeaderFooter(doc, img, userName, doctype, pageWidth, pageHeight, pageCount); // Add header/footer
                y = contentStartY; // Reset Y position
            }

            doc.text(line, pageWidth / 2, y, { align: "center" }); // Center text
            y += lineHeight;
        }

        doc.save("document.pdf");
    };

    img.onerror = function () {
        alert("Error: Could not load 'nhlogo.png'. Ensure the file exists.");
    };
}

/**
 * Adds a background color to the page
 */
function applyBackground(doc, pageWidth, pageHeight) {
    doc.setFillColor("#2a3e5f");
    doc.rect(0, 0, pageWidth, pageHeight, "F");
}

/**
 * Adds a header and footer to the page
 */
function addHeaderFooter(doc, img, userName, doctype, pageWidth, pageHeight, pageNumber) {
    // Header background
    doc.setFillColor("#4c6b9a");
    doc.rect(0, 0, pageWidth, 40, "F");

    // Logo
    doc.addImage(img, "PNG", 10, 12, 15, 15);

    // Header text
    doc.setTextColor("#e0f0ff");
    doc.setFont("times", "bold");
    doc.setFontSize(18);
    doc.text("Nintendo Homebrew", 30, 20);

    // Document type
    doc.setFont("times", "normal");
    doc.setFontSize(12);
    doc.text("Document:", pageWidth - 60, 16, { align: "right" });
    doc.text(doctype, pageWidth - 60, 24, { align: "right" });

    // Footer text
    doc.setFont("times", "normal");
    doc.setFontSize(10);
    doc.text(`${userName} - Page ${pageNumber}`, pageWidth - 20, pageHeight - 10, { align: "right" });
}

/**
 * Processes Markdown content and formats lines
 */
function parseMarkdown(content, doc, contentWidth) {
    const lines = content.split("\n");
    const processedLines = [];

    lines.forEach((line) => {
        line = line.trim();

        if (line.startsWith("# ")) {
            // Header (H1)
            doc.setFont("times", "bold");
            doc.setFontSize(20);
            const wrappedHeader = doc.splitTextToSize(line.replace(/^#\s*/, ""), contentWidth);
            processedLines.push(...wrappedHeader);
            resetFormatting(doc);
        } else if (line.startsWith("## ")) {
            // Subheader (H2)
            doc.setFont("times", "bold");
            doc.setFontSize(16);
            const wrappedSubHeader = doc.splitTextToSize(line.replace(/^##\s*/, ""), contentWidth);
            processedLines.push(...wrappedSubHeader);
            resetFormatting(doc);
        } else if (line.startsWith("- ")) {
            // Bullet points
            doc.setFont("times", "italic");
            const bulletLine = "• " + line.replace(/^- /, "");
            const wrappedBullet = doc.splitTextToSize(bulletLine, contentWidth);
            processedLines.push(...wrappedBullet);
            resetFormatting(doc);
        } else {
            // Regular text
            resetFormatting(doc);
            const wrappedText = doc.splitTextToSize(line, contentWidth);
            processedLines.push(...wrappedText);
        }
    });

    return processedLines;
}

/**
 * Resets font size, style, and color to default
 */
function resetFormatting(doc) {
    doc.setFont("times", "normal");
    doc.setFontSize(12);
    doc.setTextColor("#e0f0ff");
}
