<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/notices' }">新闻列表</el-breadcrumb-item>
            <el-breadcrumb-item>新增新闻</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-form :model="notice" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="新闻分类" prop="notice_node_id">
                <el-select v-model="notice.notice_node_id" placeholder="请选择新闻分类">
                    <el-option v-for="item in notice_nodes"
                               :key="item.id"
                               :label="item.name"
                               :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="新闻标题" prop="title">
                <el-input v-model="notice.title"></el-input>
            </el-form-item>

            <el-form-item label="缩略图" prop="image">
                <el-upload
                        class="avatar-uploader"
                        action="/photos"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                    <img v-if="notice.image" :src="notice.image" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </el-form-item>

            <el-form-item label="新闻内容">
                <quill-editor v-model="notice.body" :options="editorOption"></quill-editor>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
                <el-button @click="resetForm('ruleForm')">重置</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import 'quill/dist/quill.core.css'  //适用于VUE的富文本编辑器的引用
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'
    import {quillEditor} from 'vue-quill-editor'

    export default {
        components: {
            quillEditor
        },
        data() {
            return {
                notice_nodes: [],
                notice: {
                    notice_node_id: '',
                    title: '',
                    image: '',
                    photo_id: '',
                    body:'',
                },
                editorOption:{
                    placeholder:'请输入文章内容...'
                },
                rules: {
                    notice_node_id: [
                        {required: true, message: '请选择新闻分类', trigger: 'change'}
                    ],
                    title: [
                        {required: true, message: '请输入新闻标题', trigger: 'blur'},
                    ],
                }
            };
        },
        created() { //构造函数
            this.init()
        },
        methods: {
            init() {
                //所有分类
                axios.get(`/admin/notice_nodes`)
                    .then((res) => {
                        //console.log(res)
                        this.notice_nodes = res.data;
                    })
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post(`/admin/notices`, this.notice)
                            .then((res) => {
                                this.$message({
                                    message: '(＾－＾)新增成功',
                                    type: 'success'
                                });
                                this.$router.push({name: 'notices'})
                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            handleChange(value) {
                console.log(value);
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },

            handleAvatarSuccess(res, file) {
                this.notice.image = res.image_url;
                this.notice.photo_id = res.photo_id;
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg'||'image/png';
                const isLt3M = file.size / 1024 / 1024 < 3;

                if (!isJPG) {
                    this.$message.error('上传图片只能是 JPG/PNG 格式!');
                }
                if (!isLt3M) {
                    this.$message.error('上传图片大小不能超过 3MB!');
                }
                return isJPG && isLt3M;
            }
        }
    }
</script>

<style>
    .demo-ruleForm {
        margin-top: 30px;
    }

    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }

    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>