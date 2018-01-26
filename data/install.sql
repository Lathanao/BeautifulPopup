-- -----------------------------------------------------
-- Table `mydb`.`_DB_PREFIX_bn_template`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `_DB_PREFIX_bn_template` (
  `id_bn_template`  INT NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(128) NULL,
  `description`     TEXT(256) NULL,
  `width`           INT NULL,
  `height`          INT NULL,
  `openMethod`      VARCHAR(45) NULL,
  `closeMethod`     VARCHAR(45) NULL,
  `bgColor`         VARCHAR(45) NULL,
  `borderColor`     VARCHAR(45) NULL,
  `borderSize`      INT NULL,
  `opacity`         FLOAT NULL,
  `padding`         INT NULL,
  `date_add`        DATETIME,
  `date_upd`        DATETIME,
  PRIMARY KEY (`id_bn_template`))
ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `_DB_PREFIX_bn_template` (`name`, `description`, `width`, `height`, `openMethod`, `closeMethod`, `bgColor`, `borderColor`, `borderSize`, `opacity`, `padding`, `date_add`, `date_upd`) VALUES
('Template black', 'For every day' , 300, 300, 'dropIn', 'dropOut', '000000', '000000', 3, 0.8, 0, '2010-01-01 00:00:00', '2010-01-01 00:00:00'),
('Template blue', 'For every day' , 300, 300, 'dropIn', 'dropOut', 'EEFFFF', '0088CC', 3, 0.8, 0, '2010-01-01 00:00:00', '2010-01-01 00:00:00'),
('Template purple', 'For mother day' , 300, 300, 'dropIn', 'dropOut', 'EEBBFF', '7733CC', 10, 0.8, 0, '2010-01-01 00:00:00', '2010-01-01 00:00:00'),
('Template red', 'For christmas' , 300, 300, 'dropIn', 'dropOut', '00AA55', 'FF2244', 3, 0.8, 0, '2010-01-01 00:00:00', '2010-01-01 00:00:00');


-- -----------------------------------------------------
-- Table `mydb`.`_DB_PREFIX_bn_peaple`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `_DB_PREFIX_bn_peaple` (
  `id_bn_peaple`    INT NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(128) NOT NULL,
  PRIMARY KEY (`id_bn_peaple`))
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `_DB_PREFIX_bn_peaple` (`name`) VALUES
('Everybody'),
('Only guess (unregistered user or disconnected user)'),
('Only all registered users'),
('Only registered users who made a order allready'),
('Only registered users who never made any order');


-- -----------------------------------------------------
-- Table `mydb`.`_DB_PREFIX_bn_page`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `_DB_PREFIX_bn_page` (
  `id_bn_page`    INT NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(128) NOT NULL,
  PRIMARY KEY (`id_bn_page`))
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `_DB_PREFIX_bn_page` (`name`) VALUES
('Everywhere'),
('Only on the home page'),
('Only on page product'),
('Only on a CMS page');


-- -----------------------------------------------------
-- Table `mydb`.`_DB_PREFIX_bn_popup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `_DB_PREFIX_bn_popup` (
  `id_bn_popup` int(11) NOT NULL AUTO_INCREMENT,
  `id_bn_template` int(11) DEFAULT NULL,
  `id_bn_page` int(11) DEFAULT NULL,
  `id_bn_peaple` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `long_content` text,
  `css` text,
  `catch_email` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `timer` int(11) DEFAULT NULL,
  `nb_view` int(11) DEFAULT NULL,
  `nb_page_before_view` int(11) DEFAULT NULL,
  `expiration` int(11) DEFAULT NULL,
  `validity` date DEFAULT NULL,
  `date_add` date DEFAULT NULL,
  `date_upd` date DEFAULT NULL,
  PRIMARY KEY (`id_bn_popup`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


INSERT INTO `_DB_PREFIX_bn_popup` (`id_bn_template`, `id_bn_page`, `id_bn_peaple`, `name`, `long_content`, `css`, `catch_email`, `active`, `timer`, `nb_view`, `nb_page_before_view`, `expiration`, `validity`, `date_add`, `date_upd`) VALUES
(1, 1, 1, 'Popup Pop-Art', '<div class="modal-header"><button class="close" type="button">&times;</button></div>\r\n<div class="row" style="width: 800px;">\r\n<div class="col-md-6"><img class="img-fluid rounded float-left" src="../img/popup/picture_comic_popup.jpg" alt="" height="300px" /></div>\r\n<div class="col-md-6">\r\n<div class="form-group"><input id="exampleInputEmail1" class="form-control" type="email" value="Email address" placeholder="Email" /></div>\r\n<div><input id="merge" class="button" style="margin: 3px; padding: 3px 15px;" type="button" value="Ne pas utiliser le code" /> <input id="cancel" class="button bienvenuespan4" style="margin: 3px; padding: 3px 15px;" type="submit" value="Oui, j\'utilise mon code !" /></div>\r\n<form id="voucher" action="{if $opc}{$link-&gt;getPageLink(\'order-opc.php\', true)}{else}{$link-&gt;getPageLink(\'order.php\', true)}{/if}" method="post"><fieldset>\r\n<div id="closebutton" class="button" style="text-align: right; margin-top: 10px;"><input id="merge" class="button" style="margin: 3px; padding: 3px 15px;" type="button" value="Ne pas utiliser le code" /> <input class="button bienvenuespan4" style="margin: 3px; padding: 3px 15px;" name="submitAddDiscount" type="submit" value="Oui, je valide mon code !" /></div>\r\n<input id="discount_name" class="discount_name" name="discount_name" type="hidden" value="PRECOM20" /> <input name="submitDiscount" type="hidden" /></fieldset></form>\r\n<p class="mini">*Offre non cumulable et valable seulement pour une premi&egrave;re commande, sans minimum d\'achat.</p>\r\n</div>\r\n</div>', '    .fancybox-skin {\r\n      background-color:#fff!important;\r\n      background-image: url(\'../img/popup/fond_comic_popup.png\')!important;\r\n      background-repeat: no-repeat;\r\n      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);\r\n      border-radius: 10px;\r\n      overflow: hidden;\r\n      border: 3px solid #0088CC;\r\n    }\r\n\r\n    .fancybox-body {\r\n      padding:20px 30px 10px;\r\n      background-color:none;\r\n      text-align: center;\r\n    }\r\n\r\n    .notification h3 {\r\n      background-color: #405d9e;\r\n      font-size: 16px;\r\n      padding: 20px;\r\n      text-align: center;\r\n      width: 520px;\r\n      color: white;\r\n    }\r\n\r\n    .notification .mini {\r\n      font-size: 10px;\r\n      margin : 0;\r\n    }\r\n\r\n    button.submit{\r\n        background:url(\'../img/popup/button_ok.png\');\r\n        background-repeat: no-repeat;\r\n        width:40px;\r\n        height:30px;\r\n        background-color: none;\r\n        border: none;\r\n\r\n    }', 0, 1, 4000, 1, 2, 7, '2019-01-01', '2010-01-01', '2017-07-12'),
(3, 1, 1, 'Get top insights and news from our search experts', '<div class="modal-header"><button class="close" type="button">&times;</button></div>\r\n<div class="modal-body">\r\n<div class="sign-up-popup-title">Want to stay on top of search trends?\r\n<div class="sign-up-popup-title">Get top insights and news from our search experts</div>\r\n<p>Delivered to you daily, straight to your inbox.</p>\r\n</div>\r\n<div><form action="/" method="post" name="popup"><input class="modal-form-input modal-form-email" name="email" required="" type="email" value="" placeholder="Your email address" /> <input name="submitNewsletter" type="hidden" value="" /> <input name="action" type="hidden" value="0" /> <button class="merge modal-form-submit" type="submit">Subscribe</button></form></div>\r\n<div class="sign-up-popup-close"><a class="close" href="#">No thanks, I am not interested</a></div>\r\n</div>', '.sign-up-popup-title {\r\n    font-size: 26px;\r\n    font-weight: bold;\r\n    margin: 10px 0;\r\n    line-height: 34px;\r\n}\r\n.modal-body {\r\n    padding: 10px 40px 30px;\r\n}\r\n.sign-up-popup-message {\r\n    font-size: 15px;\r\n    color: #000;\r\n    text-align: center;\r\n    line-height: 28px;\r\n}\r\n.modal-form-container {\r\n    margin: 20px 0;\r\n}\r\n.sign-up-popup-close {\r\n    text-align: center;\r\n}\r\n.sign-up-popup-close a, .sign-up-popup-close a:hover {\r\n    text-decoration: underline;\r\n    color: #999;\r\n    margin-top:14px;\r\n    font-size: 13px;\r\n    font-style: italic;\r\n    display: block;\r\n    float: right;\r\n}\r\n\r\n\r\n.modal-form-input {\r\n    width: 100% !important;\r\n    box-sizing: border-box !important;\r\n    height: 50px;\r\n    font-size: 18px;\r\n    background-color: #fafafa;\r\n    padding-left: 40px !important;\r\n    background-image: url(/modules/beautifulpopup/img/envelope-gray.jpg);\r\n    background-repeat: no-repeat;\r\n    background-position: 10px 50%;\r\n    border-radius: 0;\r\n    margin-bottom: 10px;\r\n    padding: 2px;\r\n    border: 1px solid #757575;\r\n    font: normal 18px \'Open Sans\';\r\n}\r\n.modal-form-submit {\r\n    color: #fff;\r\n    width: 100%;\r\n    box-sizing: border-box !important;\r\n    background-color: #f16f35 !important;\r\n    height: 50px;\r\n    font-size: 22px !important;\r\n    background-position: right center;\r\n    border: 1px solid #d3612d;\r\n    border-radius: 0;\r\n}\r\n\r\n', 0, 1, 500, 999, 0, 0, '2016-12-21', '2010-01-01', '2017-07-12'),
(1, 1, 1, 'Popup Catch Email Pure Text', '<p style="text-align: right;"><button class="close" type="button">&times;</button></p>\r\n<p style="text-align: center;"><span style="font-size: 18pt;"><img src="/img/logo.jpg" alt="" width="350" height="99" /></span></p>\r\n<hr />\r\n<p style="text-align: center;"> </p>\r\n<p style="text-align: center;"> </p>\r\n<p style="text-align: center;"><span style="font-size: 18pt;">Want to stay on top of search trends?</span></p>\r\n<div class="sign-up-popup-title" style="text-align: center;"><span style="font-size: 18pt;">Get top insights and news from our search experts</span></div>\r\n<p style="text-align: center;">Delivered to you daily, straight to your inbox.</p>\r\n<p style="text-align: center;"> </p>\r\n<p style="text-align: center;"><input class="modal-form-input" type="text" /></p>\r\n<p style="text-align: center;"><a class="modal-form-submit btn btn-default" title="View" href="http://_DB_PREFIX16/en/summer-dresses/printed-chiffon-dress.html"> Subscribe </a></p>', '.modal-form-input {\r\n    width: 100% !important;\r\n    box-sizing: border-box !important;\r\n    height: 50px;\r\n    font-size: 18px;\r\n    background-color: #eee;\r\n    padding-left: 40px !important;\r\n     background-image: url(/modules/beautifulpopup/img/envelope-gray.jpg);;\r\n    background-repeat: no-repeat;\r\n    background-position: 10px 50%;\r\n    border-radius: 0;\r\n    margin-bottom: 10px;\r\n    padding: 2px;\r\n    border: 1px solid #757575;\r\n    font: normal 12px \'Open Sans\';\r\n}\r\n.modal-form-submit {\r\n    color: #fff;\r\n    width: 100%;\r\n    box-sizing: border-box !important;\r\n    background-color: #f16f35 !important;\r\n    height: 50px;\r\n    font-size: 22px !important;\r\n    background-position: right center;\r\n    border: 1px solid #d3612d;\r\n    border-radius: 0;\r\n}\r\n', 0, 0, 500, 1, 0, 0, '2020-01-01', '2010-01-01', '2017-07-15'),
(4, 1, 1, 'Comic Message Popup ', '<div class="modal-header"><button class="close" type="button">&times;</button></div>\r\n<article class="comic">\r\n<div class="panel">\r\n<p class="speech left">Hey!&nbsp;A speech bubble&nbsp;A speech bubble&nbsp;A speech bubble</p>\r\n<p class="speech right">Ho!&nbsp;A speech bubble&nbsp;A speech bubble&nbsp;A speech bubble</p>\r\n<p class="speech left">I have a great code for your next order : XXXXXXXX</p>\r\n<p class="speech right close">↪Ok, get it !</p>\r\n</div>\r\n</article>', 'html, body {\r\n  margin:0;\r\n  padding:0;\r\n}\r\n\r\n.comic {\r\n  display:flex;\r\n  flex-wrap:wrap;\r\n  font-family:\'Comic Sans\', cursive;\r\n  padding:1vmin;\r\n  width:400px;\r\n  font-size:16px;\r\n  \r\n}\r\n\r\n.panel {\r\n  background-color:#fff;\r\n  border:solid 2px #000;\r\n  box-shadow:0 6px 6px -6px #000;\r\n  display:inline-block;\r\n  flex:1 1;\r\n  height:auto;\r\n  margin:1vmin;\r\n  overflow:hidden;\r\n  position:relative;\r\n}\r\n.close {\r\n  font-size:16px;\r\n  color:#444;\r\n}\r\n.text {\r\n  background-color:#fff;\r\n  border:solid 2px #000;\r\n  margin:0;\r\n  padding:3px 10px;\r\n}\r\n\r\n.top-left {\r\n  left:-6px;\r\n  position:absolute;\r\n  top:-2px;\r\n  transform:skew(-15deg);\r\n}\r\n\r\n\r\n\r\n.speech.left, .speech.right {\r\n  background-color:#fff;\r\n  border:solid 2px #000;\r\n  border-radius:12px;\r\n  display:inline-block;\r\n  margin:.5em;\r\n  padding:.5em 1em;\r\n  position:relative;\r\n  width:50%;\r\n}\r\n.speech.right {\r\n  background-color:#fff;\r\n  border:solid 2px #000;\r\n  border-radius:12px;\r\n  display:inline-block;\r\n  margin:.5em;\r\n  padding:.5em 1em;\r\n  float:right;\r\n  position:relative;\r\n  text-align: right;\r\n}\r\n.speech.left:before {\r\n  border:solid 12px transparent;\r\n  border-left:solid 12px #000;\r\n  border-top:solid 12px #000;\r\n  bottom:-24px;\r\n  content:"";\r\n  height:0;\r\n  left:24px;\r\n  position:absolute;\r\n  transform:skew(-15deg);\r\n  width:0;\r\n}\r\n\r\n.speech.left:after {\r\n  border:solid 10px transparent;\r\n  border-left:solid 10px #fff;\r\n  border-top:solid 10px #fff;\r\n  bottom:-19px;\r\n  content:"";\r\n  height:0;\r\n  left:27px;\r\n  position:absolute;\r\n  transform:skew(-15deg);\r\n  width:0;\r\n}\r\n.speech.right:before {\r\n  border:solid 12px transparent;\r\n  border-left:solid 12px #000;\r\n  border-top:solid 12px #000;\r\n  bottom:-24px;\r\n  content:"";\r\n  height:0;\r\n  right:22px;\r\n  position:absolute;\r\n  transform:skew(45deg);\r\n  width:0;\r\n}\r\n.speech.right:after {\r\n  border:solid 10px transparent;\r\n  border-left:solid 10px #fff;\r\n  border-top:solid 10px #fff;\r\n  bottom:-19px;\r\n  content:"";\r\n  height:0;\r\n  right:27px;\r\n  position:absolute;\r\n  transform:skew(45deg);\r\n  width:0;\r\n}\r\n\r\n.speech:last-child {\r\nmargin-bottom: 30px;\r\n}\r\n\r\n.panel {\r\n  background-image:radial-gradient(circle, yellow, orange);\r\n  background-image:radial-gradient(circle, lightblue, deepskyblue);\r\n  background-image:radial-gradient(circle, palegreen, yellowgreen);\r\n  background-image:radial-gradient(circle, lightcoral, tomato);\r\n}\r\n', 0, 0, 500, 1, 0, 7, '2017-10-28', '2017-07-01', '2017-07-12'),
(4, 1, 1, 'Bridge popup and redirect on create an account', '<div class="modal-header"><button class="close" type="button">&times;</button></div>\r\n<div>\r\n<div class="modal-header">\r\n<div class="page-header">\r\n<p style="text-align: center;"><img src="/img/logo.jpg" alt="" width="350" height="99" /></p>\r\n<h1>Welcome to ShopName</h1>\r\n</div>\r\n<div class="text-content">Evernote lets you collect and find everything you need to be organized effortlessly.</div>\r\n</div>\r\n<div class="ext-padding">\r\n<div class="image-content">\r\n<div class="welcome-entry"><img src="modules/beautifulpopup/img/customer-service.png" alt="" /> Capture everything in Evernote</div>\r\n<div class="welcome-entry"><img src="modules/beautifulpopup/img/free-delivery.png" alt="" /> Access your notes anywhere</div>\r\n<div class="welcome-entry"><img src="modules/beautifulpopup/img/medal.png" alt="" /> Find what you need quickly</div>\r\n</div>\r\n<div class="submission-options"><a class="btn btn-default button button-medium" title="Proceed to checkout" href="/index.php?controller=authentication&back=my-account" rel="nofollow"> <span class="btn">Create an Account </span></a>\r\n<div class="auth">Or sign in with an existing account</div>\r\n</div>\r\n<div class="skip-link close">Skip &gt;</div>\r\n</div>\r\n</div>', '.fancybox-body {\r\n    max-width:600px;\r\n}\r\n\r\n.modal-header {\r\n    padding: 16px;\r\n}\r\n.modal-header .page-header {\r\n    margin-bottom: 16px;\r\n}\r\n.modal-header .page-header h1 {\r\n    font-size: 21px;\r\n    margin-bottom: 0;\r\n    margin-top: 4px;\r\n    padding-bottom: 12px;\r\n    color: #3b3b3b;\r\n    text-align: center;\r\n    font-weight: normal;\r\n    -webkit-font-smoothing: antialiased;\r\n}\r\n.modal-header .text-content {\r\n    font-size: 14px;\r\n    line-height: 20px;\r\n    padding: 0 40px;\r\n    font-family: helvetica, arial, sans-serif;\r\n    color: #747474;\r\n    text-align: center;\r\n    overflow: hidden;\r\n    -o-text-overflow: ellipsis;\r\n    -webkit-text-overflow: ellipsis;\r\n    text-overflow: ellipsis;\r\n}\r\n.ext-padding {\r\n    padding: 32px 16px;\r\n\r\n}\r\n.welcome-entry{\r\nflex-grow: 1;\r\n}\r\n.ext-padding .image-content {\r\n    padding: 0 8px;\r\n    display: flex;\r\n}\r\n.ext-padding .image-content .welcome-entry {\r\n    margin: 0 8px 40px;\r\n    height: 140px;\r\n    text-align: center;\r\n    flex-grow: 1;\r\n    padding: 20px;\r\n}\r\n.ext-padding .image-content .welcome-entry .welcome-image {\r\n    width: 128px;\r\n    height: 78px;\r\n    margin-bottom: 10px;\r\n    flex-grow: 1;\r\n}\r\n.ext-padding .submission-options {\r\n    clear: both;\r\n    padding-bottom: 16px;\r\n    text-align: center;\r\n    border-bottom: 1px solid #bdbdbd;\r\n}\r\ninput[type="submit"].emphasize, input[type="button"].emphasize, .general-button.emphasize, a.general-button.emphasize {\r\n    display: inline-block;\r\n    min-width: 100px;\r\n    margin: 0px;\r\n    padding: 6px 10px;\r\n    border: 1px solid #5c982c;\r\n    height: auto;\r\n    width: auto;\r\n    background: #f5f5f5;\r\n    float: none;\r\n    cursor: pointer;\r\n    background-color: #69ad31;\r\n    background-image: -moz-linear-gradient(top, #6fb536, #5fa229);\r\n    background-image: -ms-linear-gradient(top, #6fb536, #5fa229);\r\n    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#6fb536), to(#5fa229));\r\n    background-image: -webkit-linear-gradient(top, #6fb536, #5fa229);\r\n    background-image: -o-linear-gradient(top, #6fb536, #5fa229);\r\n    background-image: linear-gradient(top, #6fb536, #5fa229);\r\n    background-repeat: repeat-x;\r\n    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#ff6fb536\', endColorstr=\'#ff5fa229\', GradientType=0);\r\n    color: #747474;\r\n    line-height: 1.41666667;\r\n    font-family: helvetica, arial, sans-serif;\r\n    font-size: 1em;\r\n    font-size: 1rem;\r\n    font-family: gotham, helvetica, arial, sans-serif;\r\n    font-style: normal;\r\n    font-weight: 400;\r\n    text-align: left;\r\n    text-decoration: none;\r\n    text-indent: 0;\r\n    text-justify: auto;\r\n    text-outline: none;\r\n    text-overflow: clip;\r\n    text-shadow: none;\r\n    text-transform: none;\r\n    text-wrap: normal;\r\n    color: #ffffff;\r\n    text-align: center;\r\n    -webkit-border-radius: 2px;\r\n    -moz-border-radius: 2px;\r\n    border-radius: 2px;\r\n    -webkit-box-shadow: 0px 0px 0px #000000;\r\n    -moz-box-shadow: 0px 0px 0px #000000;\r\n    box-shadow: 0px 0px 0px #000000;\r\n    -webkit-transition: all 0.2s ease 0;\r\n    -moz-transition: all 0.2s ease 0;\r\n    -ms-transition: all 0.2s ease 0;\r\n    -o-transition: all 0.2s ease 0;\r\n    transition: all 0.2s ease 0;\r\n    -webkit-touch-callout: none;\r\n    -webkit-user-select: none;\r\n    -khtml-user-select: none;\r\n    -moz-user-select: -moz-none;\r\n    -ms-user-select: none;\r\n    user-select: none;\r\n}\r\n.ext-padding .submission-options .auth {\r\n    text-align: center;\r\n    font-family: helvetica, arial, sans-serif;\r\n    font-size: 13px;\r\n    color: #4a8db8;\r\n    cursor: pointer;\r\n    margin-top: 10px;\r\n}\r\n.ext-padding .close {\r\n    margin-top: 16px;\r\n    text-align: right;\r\n    font-family: helvetica, arial, sans-serif;\r\n    font-size: 13px;\r\n    color: #4a8db8;\r\n    cursor: pointer;\r\n}', 0, 0, 500, 1, 0, 0, '2017-10-28', '2017-07-02', '2017-07-12'),
(1, 1, 1, 'Black and White for email', '<div class="modal-header"><button class="close" type="button">&times;</button></div>\r\n<div>\r\n<h2 style="text-align: center;">Sign Up for Newsletters</h2>\r\n</div>\r\n<div style="text-align: center;">\r\n<p>Subscribe to our newsletters now and stay up-to-date with new collections, the latest lookbooks and exclusive offers.</p>\r\n</div>\r\n<div><form action="/" method="post" name="popup">\r\n<div><input class="email" name="email" type="email" placeholder="Your email address" /></div>\r\n<div class="subscribe-bottom"><button class="merge" type="submit">Subscribe</button></div>\r\n</form></div>', '.fancybox-body h2 {\r\npadding: 50px 20px;\r\n}\r\n.fancybox-body form {\r\n    text-align: center;\r\n}\r\n.fancybox-body .close{\r\ntop: -12px;\r\n}\r\n\r\n.fancybox-body .email {\r\n    background: #EBEBEB none repeat scroll 0% 0%;\r\n    border: medium none;\r\n    height: 40px;\r\n    width: 50%;\r\n    margin: 20px 0;\r\n    padding: 0 15px;\r\n}\r\n.fancybox-body h2 {\r\n    font-size: 23px;\r\n    text-transform: uppercase;\r\n    color: #000;\r\n    font-weight: 700;\r\n    letter-spacing: 1px;\r\n}\r\n.fancybox-body p {\r\nfont-weight: 400;\r\nwidth: 80%;\r\nfont-size: 14px;\r\ncolor: #999;\r\ndisplay: inline-block;\r\nmax-width: 100%;\r\nmargin-bottom: 5px;\r\n\r\n}\r\n.fancybox-body button.merge {\r\nbackground: blue;\r\nborder: 0;\r\nfont-weight: 500;\r\nfont-size: 13px;\r\npadding: 0 16px;\r\nline-height: 43px;\r\nheight: 40px;\r\ndisplay: inline-block;\r\ntext-transform: uppercase;\r\ncolor: #fff;\r\nborder-radius: 5px;\r\nmargin: 10px;\r\n}\r\n\r\n', 0, 0, 500, 1, 0, 7, '2018-03-31', '2017-07-06', '2017-07-12'),
(1, 1, 1, 'Video', '<p><iframe src="https://player.vimeo.com/video/130958817" width="640" height="360" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>\r\n<p class="close" style="text-align: right;">Close</p>', '', 0, 1, 500, 1, 0, 0, '2017-09-24', '2017-07-15', '2017-07-16');

--