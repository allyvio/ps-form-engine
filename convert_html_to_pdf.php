<?php

require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Set options for dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('defaultPaperSize', 'A4');
$options->set('defaultPaperOrientation', 'portrait');

// Initialize dompdf
$dompdf = new Dompdf($options);

// Read the HTML file
$htmlFile = __DIR__ . '/Strategic_Operations_Report_ID.html';

if (!file_exists($htmlFile)) {
    die("❌ HTML file not found: {$htmlFile}\n");
}

echo "📄 Reading HTML file: {$htmlFile}\n";
$html = file_get_contents($htmlFile);

// Fix Chart.js issues for PDF (replace with static placeholder)
$html = preg_replace('/<script src="https:\/\/cdn\.jsdelivr\.net\/npm\/chart\.js"><\/script>/', '', $html);
$html = preg_replace('/<script>.*?<\/script>/s', '', $html);

// HTML file already has CSS-based charts, no need to replace anything
// The Indonesian file uses progress bars which are PDF-compatible

echo "📝 Processing HTML content for PDF conversion...\n";

// Load HTML into dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF
echo "🔄 Rendering PDF...\n";
$dompdf->render();

// Output PDF to file
$pdfOutput = __DIR__ . '/Strategic_Operations_Report_ID.pdf';
file_put_contents($pdfOutput, $dompdf->output());

echo "✅ PDF created successfully: {$pdfOutput}\n";
echo "📊 Note: Charts are replaced with placeholders in PDF. For interactive charts, use the HTML version.\n";

// Optional: Calculate file sizes
$htmlSize = round(filesize($htmlFile) / 1024, 2);
$pdfSize = round(filesize($pdfOutput) / 1024, 2);

echo "\n📈 File Statistics:\n";
echo "HTML: {$htmlSize} KB\n";
echo "PDF: {$pdfSize} KB\n";

?>