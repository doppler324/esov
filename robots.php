<?php
use Bitrix\Main\Loader;
require_once ($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if(!Loader::includeModule("sotbit.regions"))
{
    return false;
}
$domain = new \Sotbit\Regions\Location\Domain();
$domainCode = $domain->getProp("CODE");
if(!empty($domain->getProp("UF_ROBOTS")))
    $domainRobots = $domain->getProp("UF_ROBOTS");
?>
User-Agent: *
Disallow: */index.php
Disallow: /bitrix/
Disallow: /auth/
Disallow: /personal-info/
Disallow: /sale/
Disallow: /recommend/
Disallow: /personal/
Disallow: /callback/
Disallow: /new/
Disallow: /news/
Disallow: /brands/
Disallow: /about/
Disallow: /vozmozhnosti/
Disallow: /stock/
Disallow: /popular/
Disallow: */filter/*
Disallow: */shortcut
Disallow: /*?*
Disallow: /*backurl=
Disallow: /*back_url=
Disallow: /*BACKURL=
Disallow: /*?SECTION_ID=*&*
Disallow: /*show_include_exec_time=
Disallow: /*show_page_exec_time=
Disallow: /*show_sql_stat=
Disallow: /*bitrix_include_areas=
Disallow: /*clear_cache=
Disallow: /*clear_cache_session=
Disallow: /*ADD_TO_COMPARE_LIST
Disallow: /*ORDER_BY
Disallow: /*PAGEN
Disallow: /*?print=
Disallow: /*&print=
Disallow: /*print_course=
Disallow: /*?action=
Disallow: /*&action=
Disallow: /*register=
Disallow: /*forgot_password=
Disallow: /*change_password=
Disallow: /*login=
Disallow: /*logout=
Disallow: /*auth=
Disallow: /*BACK_URL=
Disallow: /*back_url_admin=
Disallow: /*?utm_source=
Disallow: /*?bxajaxid=
Disallow: /*&bxajaxid=
Disallow: /*?view_result=
Disallow: /*&view_result=
Disallow: */eshche-/*
Disallow: /red.php

<?=(!empty($domainRobots) ? $domainRobots : "")?>