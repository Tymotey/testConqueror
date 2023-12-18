<?php
    require_once('config.php');

    $page = $_SERVER['REQUEST_URI'];
    $page = explode('?', $page);
    $page = $page[0];
    $page = str_replace('/','', $page);

    if( $page === '' ){
        $page = 'index';
    }
    $page = strtolower($page);

    if($page !== 'ajax'){
?>
<!doctype html>
<html lang="en">
	<head>
		<title>The Congueror - Timotei Bondas</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="assets/css/style.css<?php echo get_version_link_params();?>" rel="stylesheet">
        <link rel="icon" type="image/png" href="/assets/images/favicon.png" sizes="32x32">
	</head>
	<body>
        <!-- Loader -->
        <div id="loader_content" class="hidden"><div id="loader_moving"></div></div>
        <!-- Page Wrapper -->
        <div id="page_wrapper">
            <!-- Header -->
            <header role="header">
                <div id="header_line_1">
                    <div class="inner_div">
                        <a href="#">THE LORD OF THE RINGS Virtual Challenges are HERE!</a>
                    </div>
                </div>
                <div id="header_line_2">
                    <div class="inner_div">
                        <!-- Logo -->
                        <div id="logo">
                            <a href="<?php echo SITE_URL; ?>">
                                <img src="/assets/images/logo.png" alt="The Conqueror" title="The Conqueror" />
                            </a>
                        </div>
                        <!-- Main menu wrapper -->
                        <div id="main_menu_wrapper">
                            <ul id="main_menu">
                                <li class="show_dropdown">
                                    <span class="label">
                                        Challenges
                                        <span class="caret">
                                            <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0.478795 0.175736C0.717449 -0.0585787 1.10438 -0.0585787 1.34304 0.175736L5.7998 4.55147L10.2566 0.175736C10.4952 -0.0585787 10.8822 -0.0585787 11.1208 0.175736C11.3595 0.410051 11.3595 0.78995 11.1208 1.02426L6.23193 5.82426C5.99327 6.05858 5.60634 6.05858 5.36768 5.82426L0.478795 1.02426C0.240141 0.78995 0.240141 0.410051 0.478795 0.175736Z" fill="white"/></svg>
                                        </span>
                                    </span>
                                    <ul class="subnav">
                                        <li><a href="#">Item 1</a></li>
                                        <li><a href="#">Item 2</a></li>
                                    </ul>
                                </li>
                                <li class="show_dropdown">
                                    <span class="label">
                                        LOTR
                                        <span class="caret">
                                            <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0.478795 0.175736C0.717449 -0.0585787 1.10438 -0.0585787 1.34304 0.175736L5.7998 4.55147L10.2566 0.175736C10.4952 -0.0585787 10.8822 -0.0585787 11.1208 0.175736C11.3595 0.410051 11.3595 0.78995 11.1208 1.02426L6.23193 5.82426C5.99327 6.05858 5.60634 6.05858 5.36768 5.82426L0.478795 1.02426C0.240141 0.78995 0.240141 0.410051 0.478795 0.175736Z" fill="white"/></svg>
                                        </span>
                                    </span>
                                    <ul class="subnav">
                                        <li><a href="#">Item 1</a></li>
                                        <li><a href="#">Item 2</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Corporate</a>
                                </li>
                                <li>
                                    <a href="#">Shop</a>
                                </li>
                                <li id="main_cart_icon" class="icon_only">
                                    <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.3584 11H14.3584C14.9084 11 15.3584 11.45 15.3584 12C15.3584 12.55 14.9084 13 14.3584 13H4.3584C3.8084 13 3.3584 12.55 3.3584 12V2H1.3584C0.808398 2 0.358398 1.55 0.358398 1C0.358398 0.45 0.808398 0 1.3584 0H4.3584C4.9084 0 5.3584 0.45 5.3584 1V3H18.3584L14.3584 10H5.3584V11ZM4.8584 14C5.6884 14 6.3584 14.67 6.3584 15.5C6.3584 16.33 5.6884 17 4.8584 17C4.0284 17 3.3584 16.33 3.3584 15.5C3.3584 14.67 4.0284 14 4.8584 14ZM13.8584 14C14.6884 14 15.3584 14.67 15.3584 15.5C15.3584 16.33 14.6884 17 13.8584 17C13.0284 17 12.3584 16.33 12.3584 15.5C12.3584 14.67 13.0284 14 13.8584 14Z" fill="white"/></svg>
                                </li>
                            </ul>
                            <div id="main_cart_details">
                                <div id="main_cart_details_data"></div>
                                <div id="main_total_text">Total: <span id="main_total"></span>LEI</div>
                                <button id="go_to_summary">Go to summary</button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Content div wrapper -->
            <main role="contentinfo">
                <div class="inner_div">
    <?php
    }
        if (file_exists('parts/page_' . $page . '.php')) {
            // Load page by id from link
            include_once('parts/page_' . $page . '.php');
        } else {
            // If no page found load 404 page
            include_once('parts/page_404.php');
        }

    if($page !== 'ajax'){
?>
                </div>
            </main>
            <!-- Footer -->
            <footer role="footer">
                <div class="subscribe">
                    <div class="inner_div">
                        Get notified when we release a new challenge.
                    </div>
                </div>
                <div class="inner_div">
                    <div id="links_div">
                        <div id="footer_logo" class="column">
                            <a href="#">
                                <img src="/assets/images/logo_white.png" alt="The Conqueror" title="The Conqueror" />
                            </a>
                        </div>
                        <div class="column">
                            <span class="footer_header">ABOUT</span>
                            <ul class="footer_menu">
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Our Causes</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Media</a></li>
                                <li><a href="#">Support Center</a></li>
                            </ul>
                        </div>
                        <div class="column">
                            <span class="footer_header">THE CONQUEROR OFFERINGS</span>
                            <ul class="footer_menu">
                                <li><a href="#">Corporate Wellness</a></li>
                                <li><a href="#">My Virtual Mission</a></li>
                                <li><a href="#">The Conqueror Adventures</a></li>
                                <li><a href="#">Virtual Challenges</a></li>
                                <li><a href="#">Virtual Walking</a></li>
                                <li><a href="#">Virtual Race</a></li>
                                <li><a href="#">Virtual Running</a></li>
                            </ul>
                        </div>
                        <div class="column">
                            <span class="footer_header">THE CONQUEROR OFFERINGS</span>
                            <div class="text">To read our privacy notice including our GDPR policy, please click <a href="#">here</a>.</div>
                            <div class="diviver"></div>
                            <span class="footer_header">TERMS OF SERVICE</span>
                            <div class="text">To read our privacy notice including our GDPR policy, please click <a href="#">here</a>.</div>
                            <div class="diviver"></div>
                            <span class="footer_header">download the app</span>
                            <div class="text">Download app from from market.</div>
                        </div>
                    </div>
                    <div id="footnotes">
                        <div class="line_1">© ACTIONARY LIMITED ALL RIGHTS RESERVED</div>
                        <div class="line_2">THE CONQUEROR and VIRTUAL CHALLENGES are a Trademark of Actionary. THE CONQUEROR Trademark is registered in the US, UK, AU and EU. VIRTUAL CHALLENGES Trademark is registered in the EU.</div>
                    </div>
                </div>
            </footer>
        </div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script>
		var theConquerorJSData = {
			'ajax_url': '<?php echo SITE_URL; ?>/ajax',
			'site_url': '<?php echo SITE_URL; ?>',
			'summary_url': '<?php echo SITE_URL; ?>/summary',
		}
	</script>
	<script src="assets/js/script.js<?php echo get_version_link_params();?>"></script>
</body>
</html>
<?php
    }