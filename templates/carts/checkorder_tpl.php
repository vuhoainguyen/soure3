<div id="full-cart-order" class="bg">
    <?=htmlspecialchars_decode($order_confirm['body_carts'])?>
    <form action="carts/xac-nhan" id="confirm-order" name="confirm-order" method="post" accept-charset="utf-8">
        <div class="sidebar-action-confirm">
            <a class="previous-link" href="<?=$config_base?>">
                <i class="fa fa-angle-left fa-lg" aria-hidden="true"></i>
                <span><?=_quay_ve_trang_chu?></span>
            </a>
            <input type="hidden" name="id" value="<?=$order_confirm['id']?>">
            <input type="hidden" name="ok" value="1">
            <?php if($order_confirm['body_checks']==0){ ?>
            <button type="submit"><?=_xac_nhan?></button>
            <?php } ?>
        </div>
    </form>
</div>