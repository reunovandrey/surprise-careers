<?php

class Sdc_Scripts {
	public function __construct()	{
		add_action('wp_head', array($this, 'surprise_add_head_script'));
	}

	/**
	 * Singleton pattern
	 */
	public static function getInstance() {
		static $instance;
		if (!isset($instance)) {
			$instance = new self();
		}
		return $instance;
	}

	public static function surprise_add_head_script()	{
		$web_sdk_key = 'key_live_ce5tbbad6zkqjKJT5qDdUadhwtfBYbV7';

		if (!$web_sdk_key) return false;
		echo '<script>
    	// load Branch
    	(function(b,r,a,n,c,h,_,s,d,k){if(!b[n]||!b[n]._q){for(;s<_.length;)c(h,_[s++]);d=r.createElement(a);d.async=1;d.src="https://cdn.branch.io/branch-latest.min.js";k=r.getElementsByTagName(a)[0];k.parentNode.insertBefore(d,k);b[n]=h}})(window,document,"script","branch",function(b,r){b[r]=function(){b._q.push([r,arguments])}},{_q:[],_v:1},"addListener applyCode autoAppIndex banner closeBanner closeJourney creditHistory credits data deepview deepviewCta first getCode init link logout redeem referrals removeListener sendSMS setBranchViewData setIdentity track validateCode trackCommerceEvent logEvent disableTracking".split(" "), 0);
    	// init Branch
    	branch.init("'.$web_sdk_key.'");
  	</script>';
	}
}
Sdc_Scripts::getInstance();