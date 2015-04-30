<?php defined('C5_EXECUTE') or die("Access Denied.");

// template data
$contactMethod = join(', ', (array)$contact_method);
$inquiryNature = join(', and ', (array)$inquiry);

$subject = t('Inquiry from carollinton.com');
$template = <<< heredoc
<html>
	<head>
		<title>Inquiry from carollinton.com</title>
		<style type="text/css">
			body {margin:0;padding:0;font-family:Arial;font-size:13px;font-weight:normal;line-height:120%;}
			body {-webkit-text-size-adjust:none;}
			table td {border-collapse:collapse;}
			h1, .h1 {padding-top:0;padding-bottom:10px;font-family:Arial;font-size:22px;font-weight:normal;line-height:100%;}
			p, .p {font-size:12px;line-height:130%;}
			blockquote, .blockquote {font-size:14px;}
		</style>
	</head>
	<body style="background-color:#f5f5f5;" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<center>
			<br /><br />
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="height:100% !important;margin:0;padding:0;width:100% !important;">
				<tr>
					<td valign="top">
						<center>
							<h1 class="h1">Inquiry from carollinton.com</h1>
							<table cellpadding="0" cellspacing="0" width="600" style="background-color:#fff;border:1px solid #ccc;">
								<tr>
									<td valign="top">
										<table border="0" cellpadding="10" cellspacing="0" width="600">
											<tr>
												<td>
													<p class="p">You have received a property inquiry from carollinton.com regarding <strong>{$sparkProperty->getPropertyName()}</strong> (MLS ID: {$sparkProperty->getListingId()})</p>
													<p class="p">From: {$name} (<a href="mailto:{$email}">${email}</a> / {$phone})</p>
													<p class="p">Preferred contact method: {$contactMethod}</p>
													<p class="p">Nature of inquiry: {$inquiryNature}</p>
													<p class="p">Message</p>
													<blockquote class="blockquote">{$message}</blockquote>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</center>
					</td>
				</tr>
			</table>
			<br /><br />
		</center>
	</body>
</html>
heredoc;

$bodyHTML = t($template);
