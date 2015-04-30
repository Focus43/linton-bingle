<?php defined('C5_EXECUTE') or die("Access Denied.");

// template data
$link 	 = BASE_URL . View::url('properties', 'id', $sparkProperty->getPropertyID());
$message = $share_message != '' ? $share_message : '<i>None</i>';

$subject = t('%s shared a property with you from CarolLinton.com', $share_sender_name);
$template = <<< heredoc
<html>
	<head>
		<title>Shared Property</title>
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
							<h1 class="h1">{$share_sender_name} Shared A Property With You</h1>
							<table cellpadding="0" cellspacing="0" width="600" style="background-color:#fff;border:1px solid #ccc;">
								<tr>
									<td valign="top">
										<table border="0" cellpadding="10" cellspacing="0" width="600">
											<tr>
												<td>
													<p class="p">{$share_sender_name} saw a listing on <a href="http://www.carollinton.com">www.carollinton.com</a> and thought you might be interested in viewing it. To visit the property, click the link below.</p>
													<p class="p">Property name: <strong>{$sparkProperty->getPropertyName()}</strong></p>
													<p class="p">Link: <a href="{$link}">{$link}</a></p>
													<p class="p">Message from {$share_sender_name}:</p>
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
