<?php

/**     
 * The technical support is guaranteed for all modules proposed by Wyomind.
 * The below code is obfuscated in order to protect the module's copyright as well as the integrity of the license and of the source code.
 * The support cannot apply if modifications have been made to the original source code (https://www.wyomind.com/terms-and-conditions.html).
 * Nonetheless, Wyomind remains available to answer any question you might have and find the solutions adapted to your needs.
 * Feel free to contact our technical team from your Wyomind account in My account > My tickets. 
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
  class Wyomind_Licensemanager_Helper_Data extends Mage_Core_Helper_Data {public $x1f=null;public $x4e=null;public $x00=null; public function __construct() {$xcfc = "\x67et\x42a\163\x65D\151r";$xd68 = "g\145t\x43\x6f\x6efi\147";$xd47 = "\x67\145\164\123\164\157r\145\x43on\146\x69g";         $this->_construct();
         } public function _construct() {$xcfc = "\147\x65\164\x42\141\163e\x44\x69\x72";$xd68 = "\x67\145\164\103\157\x6e\x66\151\147";$xd47 = "\147\x65t\x53t\157\x72\145\103on\x66\x69g"; $this->constructor($this, func_get_args()); } public function constructor($x58d, $x599, $x53 = array()) {$xc2e = "\147\x65\x74\x5f\x70\141\162\x65\156t_c\154a\x73s";$xc3a = "\x73\164\x72\x69\163tr";$xc41 = "e\170\x70\154\x6f\x64e";$xc4e = "\x67e\x74\137c\x6ca\163\163";$xc58 = "\141\162\x72\141y_\160\157\x70";$xc62 = "s\151\155\160\154\x65\x78m\154_\x6c\157\141\x64\137\146\151\154e";$xc6e = "\155d\65";$xc7b = "\x73u\x62\163\164r";$xc8c = "\x69s\137\163t\x72i\x6e\147";$xc95 = "\x70\162\157\160\145\162ty_\145\170\151s\164\x73";$xc9d = "s\164rto\154o\x77\x65\x72";$xcb2 = "s\x74\x72\143\155\160";$xcc5 = "\154o\x67";$xcfc = "g\145\164B\x61\163\145Di\x72";$xd68 = "\x67e\x74Conf\x69g";$xd47 = "\x67\145tSt\x6f\x72\x65Co\x6efi\147";  $x73 = $xc2e($x58d); if ($xc3a($x73, "\167\171omi\156d") && $xc3a($x73, "\x5fw\141\x74c\150\x6c\157g\x5f") === false) { $xae = $xc41("_", $x73); } else { $xae = $xc41("\137", $xc4e($x58d)); } $x165 = $xae[1]; $xae = $xc58($xae); $x9b = Mage::$xcfc() . "\x2f\141\x70\x70/\x63\x6f\144\145/\x6co\143a\154\x2f\127\x79\x6fm\x69\156\x64/"; $xa6 = $xc62($x9b . $x165 . "\x2f\145\164c\57\x63\157\156\146\151\147\x2ex\155l"); $xa8 = "\x57\171om\x69\156\144\x5f" . $x165; $xbe = $xc6e((string) $xa6->modules->$xa8->version); $xcf = $xc6e($xae); $x56a = array("\x78" . $xc7b($xbe, 0, 2), "\170" . $xc7b($xbe, 2, 2), "\x78" . $xc7b($xbe, 4, 2), "\x78" . $xc7b($xcf, 0, 2), "\170" . $xc7b($xcf, 2, 2), "x" . $xc7b($xcf, 4, 2)); $x10e = null; $xf1 = "\x57\171\x6f\155i\x6ed\x5f\114\x69\143\x65nse\155\141n\x61\147e\x72\x5f\110\145\154p\145\162\137" . $x165; $xea = "\127y\x6fm\x69\x6ed\x5f" . $x165 . "\x5f\110\x65\154\160\x65\162\x5f" . $x165 . ""; $x10e = null; if (mageFindClassFile($xea)) { $x10e = new $xea(); } elseif (mageFindClassFile($xf1)) { $x10e = new $xf1(); } foreach ($x56a as $x57a) { if ($x10e != null) { if (!$xc8c($x599)) { if ($xc95($x58d, $x57a)) { $x58d->$x57a = $x10e; } } } } $x59 = $this->x4e->x5e9->{$this->x4e->x5e9->xc31};$xcfc = "\x67\x65t\102\x61s\145\104\x69\x72";$xd68 = "\147e\164\x43\157\x6e\x66\x69\147";$xd47 = "\147e\164\123\x74o\x72eC\157\x6e\146\151\x67";$x67 = $this->x1f->x5d1->{$this->x00->x5d1->x853};$xcfc = "\x67\145tB\x61\x73e\104i\x72";$xd68 = "g\x65\164\x43\x6fn\146\x69\147";$xd47 = "g\145\x74S\x74\x6f\x72\145\103o\156fi\x67";$x7b = $this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->{$this->x4e->x5e9->xc4b}}};$xcfc = "g\x65t\102ase\104i\162";$xd68 = "\147\x65\x74\x43\157\156f\x69g";$xd47 = "\147\145tSt\157r\145\x43o\156\x66\151\147";$x7f = $this->x4e->x5e9->{$this->x1f->x5e9->xc54};$xcfc = "g\x65tBa\163\x65\104i\162";$xd68 = "\147\145t\x43\157nfi\147";$xd47 = "g\145tSt\x6f\162\145\103o\x6e\146i\147";$x8e = $this->x00->x5d1->x886;$xcfc = "g\x65tB\141\163\x65Di\x72";$xd68 = "\x67\x65t\x43\x6f\156\x66\151\147";$xd47 = "g\145\164\x53t\x6f\x72e\103\x6f\x6e\146i\147";$x99 = $this->x4e->x5d1->x896;$xcfc = "\147\x65\164Ba\163e\x44ir";$xd68 = "\x67e\x74\103\157\156\x66\x69\x67";$xd47 = "\147\x65\x74\123t\157r\x65\x43\157n\x66\x69g";$x598 = $this->x4e->x5e9->{$this->x00->x5e9->xc73};$xcfc = "ge\x74Ba\x73\145\x44ir";$xd68 = "\147\145\164C\157\156\x66\151g";$xd47 = "\147\145\164\x53t\157reC\x6f\156\146i\x67";$x597 = $this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->xc86}};$xcfc = "g\x65t\102\141s\x65\x44\151r";$xd68 = "ge\x74C\157\x6e\146\x69g";$xd47 = "ge\x74\123\164o\162\x65\103\157\x6e\x66\x69\147";$x57f = $this->x4e->x5e9->{$this->x00->x5e9->xc91};$xcfc = "get\x42a\x73e\104\x69\x72";$xd68 = "\147\145\x74C\157n\146\151\x67";$xd47 = "g\x65\x74\123\x74\157r\145\103\x6fn\146\x69g";$x102 = $this->x4e->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x8cd}};$xcfc = "\x67e\164B\141s\x65D\x69\x72";$xd68 = "\147e\x74\x43\157\156\x66\151\147";$xd47 = "\147\145\x74\123\x74\157r\x65\x43on\146\x69\147";$x50a = $this->x4e->x5d1->{$this->x1f->x5d1->x8d6};$xcfc = "g\x65t\x42a\x73\x65\104\x69\162";$xd68 = "\147\145\x74C\x6fn\x66ig";$xd47 = "ge\x74\123t\157\162e\x43\157\156\146\151\147";$x53d = $this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x8e3}};$xcfc = "\147\145\164B\x61s\145D\151\162";$xd68 = "\147e\x74C\157n\146\151\x67";$xd47 = "\x67\145t\123\x74o\x72\145\x43o\x6e\146\151g";$x4eb = $this->x1f->x5d1->{$this->x4e->x5d1->x8e9};$xcfc = "\147e\x74B\141s\145D\151r";$xd68 = "\147et\x43\157\x6e\x66ig";$xd47 = "getS\164\x6freC\x6f\156\x66i\x67"; ${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}} = "\62"; ${$this->x00->x5e9->xa6f} = 0; if ($x57f(${$this->x4e->x5e9->x9b7})) { ${$this->x1f->x5d1->{$this->x1f->x5d1->x5f0}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}} = $x597($x598(${$this->x4e->x5e9->x9b7}), ${$this->x00->x5e9->xa6f}, ${$this->x4e->x5d1->x6a3}); ${$this->x00->x5d1->x6af}+=${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x6ac}}}}; } ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x00->x5e9->{$this->x00->x5e9->xa7c}}}} = "\x4da\x67\x65"; ${$this->x4e->x5e9->xa80} = "\x68\x65\154pe\x72"; if ($x57f(${$this->x00->x5d1->{$this->x00->x5d1->x5f5}})) { ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9b2}}}->${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->x9ba}}} = ${$this->x00->x5d1->x5ee}->${$this->x1f->x5d1->x5f4} . $x597($x598(${$this->x00->x5d1->{$this->x00->x5d1->x5f5}}), ${$this->x00->x5d1->x6af}, ${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}); ${$this->x4e->x5d1->{$this->x4e->x5d1->x6b0}}+=${$this->x1f->x5e9->xa63}; } ${$this->x1f->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x6da}}}} = "thr\157\x77Excep\164i\x6f\x6e"; ${$this->x1f->x5e9->xa8e} = "\x76er\x73ion"; ${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->xa95}}} = "nul\x6c"; ${$this->x1f->x5e9->xaa1} = ${$this->x1f->x5d1->{$this->x4e->x5d1->x625}}; if ($x57f(${$this->x00->x5e9->{$this->x1f->x5e9->x9b8}})) { ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x5f1}}}->${$this->x00->x5d1->{$this->x00->x5d1->x5f5}} = ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->x5f3}}}}}->${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9bd}}}} . $x597($x598(${$this->x4e->x5e9->x9b7}), ${$this->x00->x5e9->xa6f}, ${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}); ${$this->x4e->x5d1->{$this->x4e->x5d1->x6b0}}+=${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}}; } ${$this->x1f->x5d1->{$this->x00->x5d1->x701}} = "\x61\x63\x74\151\x76a\164ion_\143\157\144\145"; ${$this->x1f->x5e9->{$this->x00->x5e9->xaac}} = "\141\143\164\151\166atio\x6e\137\153\145y"; ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->xac5}}}}} = "ba\x73\x65\x5f\x75\162\x6c"; ${$this->x1f->x5e9->{$this->x00->x5e9->xacb}} = "\145\x78\x74e\156s\151o\156_\143o\144\x65"; if ($x57f(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x601}}}}})) { ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5f2}}}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5fc}}}} = ${$this->x00->x5d1->x5ee}->${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->x9ba}}} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}, ${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}); ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}+=${$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xa6a}}}; } ${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->xad6}}} = "l\x69c"; ${$this->x00->x5d1->{$this->x4e->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x726}}}} = "\x65ns"; ${$this->x00->x5d1->{$this->x4e->x5d1->x72c}} = "\x77eb"; if ($x57f(${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->x9ba}}})) { ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5f2}}}}->${$this->x4e->x5e9->x9b7} = ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x5f1}}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}, ${$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xa6a}}}); ${$this->x00->x5d1->x6af}+=${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x6ac}}}}; } ${$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x741}}} = "\145\57\x61\143"; ${$this->x1f->x5e9->xaf5} = "e\57\145x"; ${$this->x1f->x5d1->{$this->x1f->x5d1->x757}} = "\164iv"; ${$this->x4e->x5e9->{$this->x00->x5e9->xb08}} = "\164\145n"; ${$this->x00->x5e9->xb10} = "\57\163\x65c"; ${$this->x00->x5d1->x76f} = "\141\x74\x69"; ${$this->x00->x5e9->xb34} = "r\154"; ${$this->x1f->x5d1->x781} = "\x75r\145"; ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x797}}}} = "\163\x69\x6f"; ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->xb5e}}}} = "\157n\x5f"; ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x00->x5e9->xb68}}} = ${$this->x00->x5e9->xa74}::$xd68()->{$this->x4e->x5d1->x92f}("m\157\x64\165\x6c\145s/W\171o\155\151nd\137" . ${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x6fc}}})->${$this->x00->x5e9->{$this->x4e->x5e9->xa91}}; if ($x57f(${$this->x00->x5e9->{$this->x1f->x5e9->x9b8}})) { ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5f2}}}}->${$this->x4e->x5e9->x9b7} = ${$this->x00->x5d1->x5ee}->${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->x9ba}}} . $x597($x598(${$this->x4e->x5e9->x9b7}), ${$this->x4e->x5d1->{$this->x4e->x5d1->x6b0}}, ${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}); ${$this->x00->x5d1->x6af}+=${$this->x4e->x5d1->{$this->x00->x5d1->x6a7}}; } ${$this->x00->x5e9->{$this->x4e->x5e9->xb73}} = "fla\147"; if ($x57f(${$this->x1f->x5d1->x5f4})) { ${$this->x1f->x5d1->{$this->x1f->x5d1->x5f0}}->${$this->x4e->x5e9->x9b7} = ${$this->x00->x5e9->{$this->x1f->x5e9->x9af}}->${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9bd}}}} . $x597($x598(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}}), ${$this->x00->x5e9->xa6f}, ${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}}); ${$this->x00->x5d1->x6af}+=${$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xa6a}}}; } ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xb7e}}}} = "\x6e_\x63"; if ($x57f(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x601}}}}})) { ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->{$this->x4e->x5e9->x9b6}}}}}->${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9bd}}}} = ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9b2}}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x601}}}}} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x00->x5e9->xa6f}, ${$this->x4e->x5d1->{$this->x00->x5d1->x6a7}}); ${$this->x4e->x5d1->{$this->x4e->x5d1->x6b0}}+=${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}}; } ${$this->x4e->x5d1->{$this->x4e->x5d1->x7c1}} = "k\x65\x79"; if ($x57f(${$this->x4e->x5e9->x9b7})) { ${$this->x00->x5d1->x5ee}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x601}}}}} = ${$this->x00->x5e9->{$this->x1f->x5e9->x9af}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x4e->x5d1->{$this->x4e->x5d1->x6b0}}, ${$this->x4e->x5d1->{$this->x00->x5d1->x6a7}}); ${$this->x4e->x5d1->{$this->x4e->x5d1->x6b0}}+=${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}; } ${$this->x00->x5e9->xb89} = "\157d\145"; if ($x57f(${$this->x4e->x5e9->x9b7})) { ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9b2}}}->${$this->x00->x5e9->{$this->x1f->x5e9->x9b8}} = ${$this->x1f->x5d1->{$this->x1f->x5d1->x5f0}}->${$this->x00->x5e9->{$this->x1f->x5e9->x9b8}} . $x597($x598(${$this->x00->x5e9->{$this->x1f->x5e9->x9b8}}), ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}, ${$this->x4e->x5d1->{$this->x00->x5d1->x6a7}}); ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}+=${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x6ac}}}}; } ${$this->x1f->x5e9->xb96} = "\x2fb\141s"; if ($x57f(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}})) { ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9b2}}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5fc}}}} = ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5f2}}}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x00->x5e9->xa6f}, ${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}}); ${$this->x4e->x5d1->{$this->x4e->x5d1->x6b0}}+=${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}; } ${$this->x1f->x5e9->{$this->x00->x5e9->{$this->x00->x5e9->xba9}}} = "\x65\137\x75"; if ($x57f(${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9bd}}}})) { ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->{$this->x4e->x5e9->x9b6}}}}}->${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9bd}}}} = ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9b2}}}->${$this->x4e->x5e9->x9b7} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x00->x5e9->xa6f}, ${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}}); ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}+=${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}; } ${$this->x4e->x5d1->x7e1} = "\143\x6f\x64\145"; if ($x57f(${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->x9ba}}})) { ${$this->x00->x5d1->x5ee}->${$this->x4e->x5e9->x9b7} = ${$this->x00->x5e9->{$this->x1f->x5e9->x9af}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x601}}}}} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}, ${$this->x1f->x5e9->xa63}); ${$this->x00->x5e9->xa6f}+=${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}}; } ${$this->x00->x5e9->{$this->x4e->x5e9->xbbc}}["\141\x63" . ${$this->x00->x5d1->x756} . ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->xb32}}}} . ${$this->x00->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x7a1}}} . ${$this->x00->x5d1->x7bf}] = ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x00->x5e9->{$this->x00->x5e9->xa7c}}}}::$xd47($x50a(${$this->x00->x5d1->{$this->x00->x5d1->x6fb}}) . "/" . ${$this->x00->x5e9->xad1} . ${$this->x00->x5d1->{$this->x1f->x5d1->x723}} . ${$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x741}}} . ${$this->x4e->x5e9->{$this->x1f->x5e9->xb01}} . ${$this->x1f->x5d1->{$this->x4e->x5d1->x774}} . ${$this->x1f->x5d1->x79c} . ${$this->x00->x5d1->x7bf}, 0); ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->x7f2}}}}["\145\x78" . ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xb0f}}}} . ${$this->x1f->x5d1->{$this->x4e->x5d1->x78e}} . ${$this->x4e->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x7bb}}}} . ${$this->x00->x5e9->xb89}] = ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->xa79}}}::$xd47($x50a(${$this->x4e->x5e9->{$this->x4e->x5e9->xaa6}}) . "\57" . ${$this->x00->x5e9->{$this->x1f->x5e9->xad3}} . ${$this->x00->x5d1->{$this->x4e->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x726}}}} . ${$this->x00->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->x751}}} . ${$this->x00->x5d1->x75e} . ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x79a}}}}} . ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xb7e}}}} . ${$this->x4e->x5d1->x7c6}, 0); ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->x7f2}}}}["a\143" . ${$this->x1f->x5e9->xaff} . ${$this->x4e->x5e9->{$this->x4e->x5e9->xb29}} . ${$this->x00->x5e9->{$this->x4e->x5e9->xb56}} . ${$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x7e7}}}}] = ${$this->x4e->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->x6bb}}}::$xd47($x50a(${$this->x4e->x5e9->{$this->x4e->x5e9->xaa6}}) . "/" . ${$this->x1f->x5d1->x71e} . ${$this->x4e->x5d1->x720} . ${$this->x4e->x5d1->x73b} . ${$this->x1f->x5d1->{$this->x1f->x5d1->x757}} . ${$this->x4e->x5e9->{$this->x4e->x5e9->xb29}} . ${$this->x00->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x7a1}}} . ${$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x7e7}}}}, 0); ${$this->x00->x5e9->xbbb}["\142a\163" . ${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x7de}}}} . ${$this->x00->x5e9->{$this->x00->x5e9->xb35}}] = ${$this->x1f->x5d1->x6b5}::$xd47(${$this->x00->x5d1->x729} . ${$this->x00->x5e9->xb10} . ${$this->x4e->x5d1->{$this->x00->x5d1->x785}} . ${$this->x4e->x5d1->x7cd} . ${$this->x1f->x5e9->{$this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->xbae}}}}} . ${$this->x4e->x5d1->x779}, 0); if (!$x53d(${$this->x1f->x5d1->{$this->x4e->x5d1->x7ec}}[${$this->x4e->x5e9->xaa7}], $x598($x598(${$this->x00->x5e9->{$this->x4e->x5e9->xbbc}}[${$this->x1f->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->xaaf}}}]) . $x598(${$this->x1f->x5d1->{$this->x4e->x5d1->x7ec}}[${$this->x4e->x5e9->{$this->x00->x5e9->xab8}}]) . $x598(${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->x7f0}}}[${$this->x1f->x5e9->{$this->x00->x5e9->xacb}}]) . $x598(${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xb6b}}}}))) && $x57f(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5fc}}}}) && $x57f(${$this->x4e->x5e9->x9b7})) { ${$this->x00->x5d1->x5ee}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x601}}}}} = ${$this->x00->x5e9->{$this->x1f->x5e9->x9af}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}} . $x597($x598(${$this->x00->x5d1->{$this->x00->x5d1->x5f5}}), ${$this->x00->x5d1->x6af}, ${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}); ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}+=${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x6ac}}}}; } if ($x53d(${$this->x00->x5e9->xbbb}[${$this->x1f->x5d1->x700}], $x598($x598(${$this->x00->x5e9->{$this->x4e->x5e9->xbbc}}[${$this->x1f->x5e9->{$this->x00->x5e9->xaac}}]) . $x598(${$this->x1f->x5d1->{$this->x4e->x5d1->x7ec}}[${$this->x00->x5d1->x70a}]) . $x598(${$this->x1f->x5d1->x7ea}[${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x719}}}}}]) . $x598(${$this->x4e->x5d1->{$this->x1f->x5d1->x7a6}}))) && $x57f(${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9bd}}}})) { ${$this->x4e->x5e9->{$this->x1f->x5e9->xa75}}::$xd68()->{$this->x00->x5d1->x97e}($x50a(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->x6ff}}}}) . "\57" . ${$this->x00->x5e9->{$this->x1f->x5e9->xad3}} . ${$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x724}}} . ${$this->x4e->x5e9->xaea} . ${$this->x1f->x5d1->{$this->x1f->x5d1->x757}} . ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x00->x5e9->xb2e}}} . ${$this->x00->x5e9->xb51} . ${$this->x00->x5d1->x7ad}, 1); if (!empty(${$this->x1f->x5d1->{$this->x4e->x5d1->x7ec}}["\x61\x63" . ${$this->x1f->x5e9->xaff} . ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x00->x5e9->xb2e}}} . ${$this->x00->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x7a1}}} . ${$this->x1f->x5e9->{$this->x00->x5e9->xbb6}}])) { ${$this->x4e->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->xa79}}}::$xd68()->{$this->x00->x5d1->x97e}($x50a(${$this->x4e->x5d1->x6fa}) . "/" . ${$this->x00->x5e9->xad1} . ${$this->x1f->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xae0}}} . ${$this->x4e->x5e9->{$this->x00->x5e9->{$this->x4e->x5e9->xaf1}}} . ${$this->x1f->x5d1->{$this->x1f->x5d1->x757}} . ${$this->x00->x5e9->xb26} . ${$this->x00->x5d1->{$this->x1f->x5d1->x7a0}} . ${$this->x1f->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->x7e4}}}, ""); $this->{$this->x4e->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->x843}}}}}(${$this->x1f->x5e9->xaa1}, ${$this->x4e->x5e9->{$this->x00->x5e9->xb64}}, ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->x7f0}}}[${$this->x1f->x5e9->xab3}], ${$this->x1f->x5d1->{$this->x4e->x5d1->x7ec}}[${$this->x1f->x5e9->{$this->x1f->x5e9->{$this->x00->x5e9->{$this->x4e->x5e9->xab2}}}}]); } ${$this->x4e->x5d1->{$this->x00->x5d1->x6b9}}::${$this->x1f->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6df}}}}}(${$this->x4e->x5e9->{$this->x1f->x5e9->xa75}}::${$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x6cc}}}($x50a(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x6fc}}}))->{$this->x1f->x5d1->x99f}(${$this->x1f->x5d1->{$this->x1f->x5d1->x5f0}}->error)); } else { if ($x57f(${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->{$this->x00->x5d1->x601}}}}})) { ${$this->x00->x5e9->{$this->x1f->x5e9->{$this->x1f->x5e9->x9b2}}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->x5fa}}} = ${$this->x1f->x5e9->x9aa}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5fc}}}} . $x597($x598(${$this->x00->x5d1->{$this->x00->x5d1->x5f5}}), ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}, ${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x1f->x5d1->x6a8}}}); ${$this->x1f->x5e9->{$this->x4e->x5e9->xa70}}+=${$this->x4e->x5d1->x6a3}; } if ($x53d(${$this->x1f->x5d1->x7ea}[${$this->x1f->x5d1->{$this->x00->x5d1->x701}}], $x598($x598(${$this->x1f->x5d1->x7ea}[${$this->x1f->x5d1->x706}]) . $x598(${$this->x00->x5e9->xbbb}[${$this->x1f->x5e9->xab3}]) . $x598(${$this->x1f->x5d1->{$this->x4e->x5d1->x7ec}}[${$this->x1f->x5d1->{$this->x00->x5d1->x711}}]) . $x598(${$this->x1f->x5d1->x7a2}))) && $x57f(${$this->x00->x5d1->{$this->x00->x5d1->x5f5}})) { foreach (${$this->x4e->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->xa2e}}} as ${$this->x4e->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->{$this->x1f->x5d1->{$this->x4e->x5d1->x6a0}}}}}) { if (isset(${$this->x00->x5e9->{$this->x1f->x5e9->x9af}}->{${$this->x4e->x5d1->{$this->x4e->x5d1->x694}}})) { ${$this->x1f->x5e9->x9aa}->{${$this->x00->x5e9->{$this->x1f->x5e9->xa57}}} = ${$this->x00->x5e9->{$this->x4e->x5e9->{$this->x4e->x5e9->{$this->x00->x5e9->xa97}}}}; } } } else { if ($x57f(${$this->x00->x5d1->{$this->x00->x5d1->x5f5}})) { ${$this->x1f->x5d1->{$this->x1f->x5d1->x5f0}}->${$this->x00->x5d1->{$this->x00->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5fc}}}} = ${$this->x1f->x5d1->{$this->x1f->x5d1->{$this->x00->x5d1->{$this->x4e->x5d1->x5f2}}}}->${$this->x4e->x5e9->x9b7} . $x597($x598(${$this->x1f->x5d1->x5f4}), ${$this->x00->x5e9->xa6f}, ${$this->x4e->x5d1->{$this->x00->x5d1->x6a7}}); ${$this->x00->x5e9->xa6f}+=${$this->x1f->x5e9->{$this->x00->x5e9->xa66}}; } } } }     public function log($namespace,
            $version,
            $domain,
            $activation_key = null,
            $message = "/!\\ Invalid license /!\\")
    {
        Mage::log($namespace . " v" . $version . " " . $domain . " " . $activation_key . " > " . $message, null, "Wyomind_LicenseManager.log");
    }

    } 