<?php //トップページ用 ?><?php get_header(); ?>
<!DOCTYPE html>
<html>
<head>
<title></title>

</head>

<body>
	<h1 class="h1-order">送信が完了いたしました</h1>
	<?php
session_start();
$pdf_url = isset($_SESSION['cf7_pdf_download']) ? $_SESSION['cf7_pdf_download'] : '';
unset($_SESSION['cf7_pdf_download']); // セッションをクリア
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var pdfUrl = "<?php echo esc_js($pdf_url); ?>";
    if (pdfUrl) {
        var link = document.createElement("a");
        link.href = pdfUrl;
        link.download = "document-pdf.pdf"; // ダウンロード時のファイル名
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
});
</script>

<p style="text-align: center;">PDFのダウンロードが開始されない場合は、<a href="<?php echo esc_url($pdf_url); ?>" download>こちらをクリック</a>してください。</p>
<br>
<p style="text-align: center;">ご提出ありがとうございます。FC研修受講状況一覧の反映内容をご確認ください。</p>
<p style="text-align: center;">送信済みのデータの修正等をご希望の場合は、お手数ですが担当者へご連絡ください。</p>
<br>
	<div class="button-container">
  <a href="https://kdmpls-portal.com/training/" class="btn-link">FC研修受講記録提出のフォームへ戻る</a>
</div>
<?php echo do_shortcode('[flamingo_training_submissions] '); ?>
</body>	

<?php get_footer(); ?>

</html>