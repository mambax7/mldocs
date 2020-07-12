<?php
//$Id: error.php,v 1.4 2004/12/08 16:18:31 eric_juden Exp $
require_once('header.php');

$xoopsOption['template_main'] = 'mldocs_error.html';
include(XOOPS_ROOT_PATH . '/header.php');

$xoopsTpl->assign('xoops_module_header', $mldocs_module_header);
$xoopsTpl->assign('mldocs_imagePath', XOOPS_URL . '/modules/mldocs/images/');
$xoopsTpl->assign('mldocs_message', _MLDOCS_MESSAGE_NO_REGISTER);

include(XOOPS_ROOT_PATH . '/footer.php');
?>