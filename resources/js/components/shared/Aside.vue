<template>
    <el-menu
            default-active="/"
            class="el-menu-vertical-demo"
            :router="true"
            background-color="#545c64"
            text-color="#fff"
            active-text-color="#ffd04b">

        <el-menu-item index="/">
            <span slot="title">
                <i class="el-icon-menu"></i>首&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;页
            </span>
        </el-menu-item>

        <el-submenu index="1">
            <template slot="title">
                <i class="el-icon-edit"></i>
                <span>课程管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/overviews"><i class="el-icon-view"></i>课程概览</el-menu-item>
                <el-menu-item index="/courses"><i class="el-icon-tickets"></i>课程列表</el-menu-item>
                <el-menu-item index="/course_nodes"><i class="el-icon-menu"></i>课程分类</el-menu-item>
                <el-menu-item index="/tags"><i class="el-icon-date"></i>标签列表</el-menu-item>
            </el-menu-item-group>
        </el-submenu>
        <el-submenu index="2">
            <template slot="title">
                <i class="el-icon-document"></i>
                <span>新闻管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/notices"><i class="el-icon-tickets"></i>新闻列表</el-menu-item>
                <el-menu-item index="/notice_nodes"><i class="el-icon-date"></i>新闻分类</el-menu-item>
            </el-menu-item-group>
        </el-submenu>
        <el-submenu index="3">
            <template slot="title">
                <i class="el-icon-location"></i>
                <span>酷站管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/sites"><i class="el-icon-tickets"></i>酷站列表</el-menu-item>
                <el-menu-item index="/site_nodes"><i class="el-icon-date"></i>酷站分类</el-menu-item>
            </el-menu-item-group>
        </el-submenu>
        <el-submenu index="4">
            <template slot="title">
                <i class="el-icon-service"></i>
                <span>广告中心</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/adverts"><i class="el-icon-tickets"></i>广告列表</el-menu-item>
                <el-menu-item index="/advert_nodes"><i class="el-icon-date"></i>广告分类</el-menu-item>
            </el-menu-item-group>
        </el-submenu>
    </el-menu>
</template>

<script>
    export default {

    }
</script>


<style>
    .el-menu-item-group__title {
        padding: 0;
    }
</style>
