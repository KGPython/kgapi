/* 初始化菜单 */
/** 权限 **/
INSERT INTO `ucenter`.`uc_privilege` VALUES (1,'百货每日数据','/','百货每日数据','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (2,'整体数据','/','整体数据','','1','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (3,'门店数据','/','门店数据','','1','2','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (50,'便利店每日数据','/','便利店每日数据','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (51,'整体数据','/','整体数据','','50','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (52,'门店数据','/','门店数据','','50','2','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (53,'SL值','/','SL值','','50','3','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (100,'超市每日数据','/','超市每日数据','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (101,'每日数据','/','每日数据','','100','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (102,'月度数据','/','月度数据','','100','2','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (103,'部类达成','/','部类达成','','100','3','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (104,'门店达成','/','门店达成','','100','4','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (105,'实时销售','/','实时销售','','100','5','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (106,'经营数据','/','经营数据','','100','6','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (107,'同比环比','/','同比环比','','100','7','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (108,'部类占比','/','部类占比','','100','8','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (109,'SL值','/','SL值','','100','9','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (110,'库存周转天数','/','库存周转天数','','100','10','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (150,'承批商贸每日数据','/','承批商贸每日数据','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (151,'销售日报','/','销售日报','','150','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (152,'库存情况','/','库存情况','','150','2','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (153,'进货退货','/','进货退货','','150','3','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (200,'商品市调','/','商品市调','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (201,'扫码市调','/','扫码市调','','200','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (202,'手动市调','/','手动市调','','200','2','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (250,'商品查询','/','商品查询','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (251,'扫码查询','/','扫码查询','','250','1','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (300,'停车场数据','/','停车场数据','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (301,'累计数据','/','累计数据','','300','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (302,'异常车辆','/','异常车辆','','300','2','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (350,'物流配送','/','物流配送','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (351,'课组库存','/','课组库存','','350','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (352,'配送明细','/','配送明细','','350','2','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (353,'配送累计数据','/','配送累计数据','','350','3','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (354,'进货退货','/','进货退货','','350','4','1','0',NOW());

INSERT INTO `ucenter`.`uc_privilege` VALUES (400,'云商贸每日数据','/','云商贸每日数据','','','1','1','0',NOW());
INSERT INTO `ucenter`.`uc_privilege` VALUES (401,'门店数据','/','门店数据','','400','1','1','0',NOW());

/** 角色 **/
INSERT INTO `ucenter`.`uc_role` VALUES (1,'集团高层','1','集团高层','1');
INSERT INTO `ucenter`.`uc_role` VALUES (2,'超市高管','2','超市高管','1');
INSERT INTO `ucenter`.`uc_role` VALUES (3,'百货高管','3','百货高管','1');
INSERT INTO `ucenter`.`uc_role` VALUES (4,'便利店高管','4','便利店高管','1');
INSERT INTO `ucenter`.`uc_role` VALUES (5,'承批商贸高管','5','承批商贸高管','1');
INSERT INTO `ucenter`.`uc_role` VALUES (6,'物流高管','6','物流高管','1');
INSERT INTO `ucenter`.`uc_role` VALUES (7,'云商贸高管','7','云商贸高管','1');

/** 普通客户菜单 **/



