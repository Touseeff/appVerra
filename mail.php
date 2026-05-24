<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = strip_tags(trim($_POST['name'] ?? ''));
    $email    = strip_tags(trim($_POST['email'] ?? ''));
    $number   = strip_tags(trim($_POST['number'] ?? ''));
    $budget   = strip_tags(trim($_POST['budget'] ?? ''));
    $message  = strip_tags(trim($_POST['msg'] ?? ''));
    $services = isset($_POST['service']) ? implode(", ", $_POST['service']) : 'None';

    // Hidden tracking fields
    $page_url = $_POST['page_url'] ?? '';
    $ip       = $_POST['ip'] ?? '';
    $isp      = $_POST['isp'] ?? '';
    $org      = $_POST['org'] ?? '';
    $country  = $_POST['country'] ?? '';
    $region   = $_POST['region'] ?? '';
    $city     = $_POST['city'] ?? '';

    $to      = "info@appverra.co";
    $subject = "New Lead: " . $name . " via Appverra";

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Appverra <info@appverra.co>\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $body = "
    <html>
    <body style='font-family:Arial,sans-serif;color:#333;'>
        <h2 style='color:#000;'>New Contact Form Submission</h2>
        <table cellpadding='8' cellspacing='0' style='border-collapse:collapse;width:100%;'>
            <tr><td style='background:#f4f4f4;font-weight:bold;width:160px;'>Name</td><td>{$name}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Email</td><td>{$email}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Phone</td><td>{$number}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Budget</td><td>{$budget}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Services</td><td>{$services}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Message</td><td>{$message}</td></tr>
        </table>
        <h3 style='color:#000;margin-top:24px;'>Visitor Info</h3>
        <table cellpadding='8' cellspacing='0' style='border-collapse:collapse;width:100%;'>
            <tr><td style='background:#f4f4f4;font-weight:bold;width:160px;'>Page URL</td><td>{$page_url}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>IP Address</td><td>{$ip}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>ISP</td><td>{$isp}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Organization</td><td>{$org}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Country</td><td>{$country}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>Region</td><td>{$region}</td></tr>
            <tr><td style='background:#f4f4f4;font-weight:bold;'>City</td><td>{$city}</td></tr>
        </table>
    </body>
    </html>
    ";

    if (mail($to, $subject, $body, $headers)) {
        header("Location: /thankyou");
        exit;
    } else {
        header("Location: /contact-us?status=fail");
        exit;
    }

} else {
    header("Location: /contact-us");
    exit;
}
