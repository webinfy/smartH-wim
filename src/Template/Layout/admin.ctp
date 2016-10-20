<?php echo $this->element('Admin/header'); ?>
<?php echo $this->element('script_file'); ?>
<style>
    .main-content {
        counter-reset: sec;
    }
    .custom_field_counter::before {
        counter-increment: sec;
        content:  counter(sec);
    }
    /*******Succes & Error Message Start*******/
    div.message::before {
        background-color: #fff;
        border-radius: 15px;
        color: #1AAF65;
        content: "i";
        display: inline-block;
        font-size: 16px;
        left: -11px;
        padding: 6px 8px 5px;
        position: relative;
        text-align: center;
        vertical-align: middle;
        width: 12px;
    }
    div.message {
        background-color: #1AAF65;
        color: #FFF;
        cursor: pointer;
        display: block;
        font-size: 14px;
        font-weight: normal;
        overflow: hidden;
        padding: 8px 20px;
        position: fixed;
        right: 15px;
        top: 40px;
        transition: height 300ms ease-out 0s;
        z-index: 999;
    }
    div.message.error {
        background-color: #C3232D;
        color: #FFF;
    }
    div.message.error:before {   
        color: #C3232D;
        content: "x";
    }
</style>
<?= $this->Flash->render() ?>
<?php echo $this->element('Admin/sidebar'); ?>
<?= $this->fetch('content') ?>
<?php echo $this->element('Admin/footer'); ?>