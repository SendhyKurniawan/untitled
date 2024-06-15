<section class="heropage grid2c">
    <div class="header-wrap fade-in left">
        <div class="title-wrap">
            <span class="bersamakita"><?php echo htmlspecialchars($heroTitle1); ?></span><span class="hentikan"><?php echo htmlspecialchars($heroTitle2); ?></span>
        </div>
        <p class="subtitle"><?php echo htmlspecialchars($heroSubtitle); ?></p>
        <a href="lapor.php">
            <button class="btnhero" type="button" onclick="window.location.href='lapor.php'"><?php echo htmlspecialchars($heroButtonLabel); ?></button>
        </a>
    </div>
    <div class="heroimg-wrap ">
        <img class="heroimg fade-in right" src="<?php echo htmlspecialchars($heroImageSrc); ?>" />
    </div>
</section>