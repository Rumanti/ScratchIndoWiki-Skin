<?php
/**
 * Scratch skin
 *
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

#require_once( dirname( dirname( __FILE__ ) ) . '/includes/SkinTemplate.php');

class SkinScratchWikiSkin extends SkinTemplate{
	var $useHeadElement = true;

	var $skinname = 'scratchwikiskin', $stylename = 'scratchwikiskin',
	$template = 'ScratchWikiSkinTemplate';
	
	function initPage(OutputPage $out) {
		

		parent::initPage( $out );

		
	}
	
	function setupSkinUserCss(OutputPage $out) {
		global $wgLocalStylePath;
		parent::setupSkinUserCss($out);
		$out->addStyle('scratchwikiskin/main.css', 'screen');
		
		$out->addHeadItem('skinscript', "<script type='text/javascript' src='$wgLocalStylePath/scratchwikiskin/skin.js'></script>");
	}
}

class ScratchWikiSkinTemplate extends BaseTemplate{
	public function execute() {
		global $wgRequest, $wgStylePath, $wgUser;
		$skin = $this->data['skin'];
		wfSuppressWarnings();
		$this->html('headelement');
		
		?>
<!-- Scratch Navigation Bar -->
<!-- Terjemahan mengikuti terjemahan di http://translate.scratch.mit.edu/id/ versi terbaru -->
<header>
	<div class="container">
		
			<a class= "scratch" href = "http://scratch.mit.edu"></a>
		
		<ul class="left">
			<li><a href="http://scratch.mit.edu/projects/editor/">Buat</a></li>
			<li><a href="http://scratch.mit.edu/explore/?date=this_month">Jelajah</a></li>
			<li><a href="http://scratch.mit.edu/discuss/">Diskusi</a></li>
			<li class = "last"><a href="http://scratch.mit.edu/help/">Bantuan</a></li>
		
		<!-- search (cari) -->
			<li>
				<form action="<?php $this->text( 'wgScript' ) ?>" class="search">
					<!--<span class="glass"><i></i></span>-->
					<input type= "submit" class= "glass" value= ""> 
					<input type="search" id="searchInput" accesskey="f" title="Cari Scratch Indo Wiki [alt-shift-f]"  name="search" autocomplete="off" placeholder="Cari Wiki ini"  />
					<input type="hidden" class="searchButton" id="mw-searchButton" title="Search the pages for this text" value="Search" />
					<input type="hidden" value="Special:Search" name="title" />
				</form>
			</li>
		</ul>
		<ul class="user right">
			
			
			<!-- user link-->
<?php	if (!$wgUser->isLoggedIn()) { ?>
			<li class = last>
                <a href="<?php if (isset($this->data['personal_urls']['anonlogin'])){echo htmlspecialchars($this->data['personal_urls']['anonlogin']['href']);}else{echo $this->data['personal_urls']['login']['href'];}?>">Masuk</a>
            </li>
<?php	} else { ?>
			<li id="userfcttoggle" class="last">
                <a><?=htmlspecialchars($wgUser->mName)?><span class = caret></span></a>
            </li>
			<ul id=userfctdropdown class="dropdownmenu"><?php foreach ($this->data['personal_urls'] as $key => $tab):?>
				<li<?php if ($tab['class']):?> class="<?=htmlspecialchars($tab['class'])?>"<?php endif?>><a href="<?=htmlspecialchars($tab['href'])?>"><?=htmlspecialchars($tab['text'])?></a><?php endforeach?>
			</ul>
<?php	} ?>
		</ul>
	</div>
</header>
<!-- that menu on the left -->
<div class="container main">
	<div class=main-inner>
		<div class=left>
		<div class = "wikilogo_space"><a class = "wikilogo" href = "<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ); ?>" title = "Halaman Utama"></a></div>
<?php		foreach ($this->getSidebar() as $box): if ($box['header']!='Toolbox'||$wgUser->isLoggedIn()){?>
			<div class=box>
				<!-- <?=print_r($box);?> -->
				<h1><?=htmlspecialchars($box['header'])?></h1>
<?php			if (is_array($box['content'])):?>
				<ul class=box-content>
<?php				foreach ($box['content'] as $name => $item):?>
					<?=$this->makeListItem($name, $item)?>
<?php				endforeach;
				?>
				</ul>
<?php
			else:?>
				<?=$box['content']?>
<?php			endif?>
			</div>
<?php		} endforeach?>
<?php		$this->renderContenttypeBox();
			if (!$wgUser->isLoggedIn()) { ?>
			<div class=box>
				
				<h1>Bantu wiki ini!</h1>
				<div class=box-content>
				Scratch-Indo-Wiki dibuat oleh dan untuk Scratcher. Apakah kamu ingin membantu?<br><br>
				<a href="/wiki/Scratch-Indo-Wiki:Bergabung">Cari lebih jauh tentang bergabung sebagai kontributor!</a><br><br>
				<a href = "/wiki/Halaman_Pembicaraan_Scratch-Indo-Wiki:Portal Komunitas">Lihat perdiskusian di Portal Komunitas</a>
				</div>
				
			</div>
<?php		} ?>
		</div>
		<div class=right>
			<?php if( $this->data['newtalk'] ) { ?><div class="box"><h1><?php $this->html('newtalk') ?></h1></div><?php } ?>
			<?php if( $this->data['catlinks'] && $wgUser->isLoggedIn()) {
			$cat = $this->data['catlinks'];
			if(strpos($cat, 'How To Pages')> 0) {
				$o =	'<div class="box ctype ctype-helppage">'.
			 	'<h1>Halaman Panduan</h1>'.
				'<div class=box-content>'.
				'Halaman ini mengandung panduan <em>step by step</em> cara melakukan sesuatu untuk pengguna baru. Sebelum menyunting, baca <a href = /wiki/Bantuan:Halaman_Panduan>pedoman halaman panduan.</a></div>'.
				'</div>';
				echo $o;
				

			} 
			
		} 	?>
			<article class=box>
				<h1><?php $this->html('title')?>
				<div id=pagefctbtn></div>
				<ul id=pagefctdropdown class="dropdownmenu box">
<?				foreach ($this->data['content_actions'] as $key => $tab):?>
					<?=$this->makeListItem($key, $tab)?>
<?				endforeach?>
				</ul>
				</h1>
				<div class=box-content>
<?php if ($this->data['subtitle']):?><p><?php $this->html('subtitle')?></p><?php endif?>
<?php if ($this->data['undelete']):?><p><?php $this->html('undelete')?></p><?php endif?>
<?php $this->html('bodytext')?>
<?php if ( $this->data['catlinks'] ): ?>
<!-- catlinks -->
<?php $this->html( 'catlinks' ); ?>
<!-- /catlinks -->
<?php endif; ?>
				</div>
			</article>
<?php   
// generate additional footer links
$footerlinks = array(
        'lastmod', 
// 'viewcount',
);
?>
        		<ul id="f-list">
<?php
foreach ( $footerlinks as $aLink ) {
        if ( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>              		<li id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></li>
<?php   }
}
?>
        		</ul>
		</div>
	</div>
</div>
<footer>
	<div class="container">
        
        <style>
          footer ul.footer-col li {
            list-style-type:none;
            display: inline-block;
            width: 184px;
            text-align: left;
            vertical-align: top;
          }

          footer ul.footer-col li h4 {
            font-weight: bold;
            font-size: 14px;
            color: #666;
          }


        </style>
          <ul class="clearfix footer-col">
            <li>
              <h4>Tentang</h4>
              <ul>
                <li><a href ="http://scratch.mit.edu/about/">Tentang Scratch</a></li>
                <li><a href = "http://scratch.mit.edu/parents/">Untuk Orangtua</a></li>
                <li><a href = "http://scratch.mit.edu/educators/">Untuk Pendidik</a></li>
                <li><a href ="http://scratch.mit.edu/jobs/">Peluang</a></li>
              </ul>
            </li>
            <li>
              <h4>Komunitas</h4>
              <ul>
                <li><a href = "http://scratch.mit.edu/community_guidelines/">Pedoman Komunitas</a></li>
                <li><a href = "http://scratch.mit.edu/discuss/">Forum Berdiskusi</a></li>
                <li><a href = "http://wiki.scratch.mit.edu/">Scratch Wiki</a></li>
                <li><a href = "http://scratch.mit.edu/statistics/">Statistik</a></li>
              </ul>
            </li>
            <li>
              <h4>Bantuan</h4>
              <ul>
                <li><a href = "http://scratch.mit.edu/help/">Halaman Bantuan</a></li>
                <li><a href = "http://scratch.mit.edu/help/faq/">Tanya Jawab</a></li>
                <li><a href = "http://scratch.mit.edu/scratch2download/">Editor Offline</a></li>
                <li><a href = "http://scratch.mit.edu/contact-us/">Kontak Kami</a></li> 
              </ul>
            </li>
            <li>
              <h4>Legal</h4>
              <ul>
                <li><a href="http://scratch.mit.edu/terms_of_use/">Kebijakan Pengguna</a></li>
                <li><a href="http://scratch.mit.edu/privacy_policy/">Kebijakan Privasi</a></li>
                <li><a href = "http://scratch.mit.edu/DMCA/">DMCA</a></li>
              </ul>
            </li>
            <li>
              <h4>Keluarga Scratch</h4>
              <ul>
              	<li><a href="http://scratched.gse.harvard.edu/">ScratchEd</a>
              	<li><a href="http://scratchjr.org">ScratchJr</a>
              	<li><a href="http://day.scratch.mit.edu">Scratch Day</a>
         	<li><a href="http://scratch.mit.edu/conference/">Scratch Conference</a>
                <li><a href="http://codetolearn.org">Code-to-Learn Foundation</a>
                <br />
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="donatePaypal">
                          <!-- input type="hidden" name="amount" value="1234"/ -->
                          <input type="hidden" name="cmd" value="_xclick">
                          <input type="hidden" name="business" value="paypal@codetolearn.org">
                          <input type="hidden" name="item_name" value="Code To Learn">
                          <input type="hidden" name="no_shipping" value="1">
                          <input type="hidden" name="return" value="http://scratch.mit.edu/">
                          <input type="hidden" name="cancel_return" value="http://scratch.mit.edu/">
                          <a href="javascript:document.forms['donatePaypal'].submit();">Donasi</a>
                </form>
                </li>
              </ul>
            </li>
          </ul>
<br>
<p >Scratch adalah sebuah proyek dari Lifelong Kindergarten Group di MIT Media Lab</p>
</footer>

        <?php $this->printTrail(); ?>

		<?php

	}
	protected function renderContenttypeBox() {
		global $wgStylePath, $wgUser;
			
		
		
	}
}
