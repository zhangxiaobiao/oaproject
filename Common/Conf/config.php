<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
//    'DB_TYPE'               =>  'mysql',     // 数据库类型
//    'DB_HOST'               =>  'localhost', // 服务器地址
//    'DB_NAME'               =>  'db_oa',          // 数据库名
//    'DB_USER'               =>  'root',      // 用户名
//    'DB_PWD'                =>  'root',          // 密码
//    'DB_PORT'               =>  '3306',        // 端口
//    'DB_PREFIX'             =>  'tp_',    // 数据库表前缀
//    //字段映射的反映射
//    //'READ_DATA_MAP'         =>  'true',
//    'SHOW_PAGE_TRACE'       =>  'true',

    //RBAC部分
    'RBAC_ROLES'             =>array(
        1   =>   '高层领导',
        2   =>   '中层管理',
        3   =>   '基层员工',
    ),
    //用户组对应的权限数组
    'RBAC_AUTHS'             =>array(
        1   =>   array('*/*'),//*表示全部权限，/用来分割控制器方法
        2   =>   array('index/*', 'email/*', 'user/*', 'doc/*'),
        3   =>   array('index/*', 'email/*', 'knowledge/showlist'),
    ),
);