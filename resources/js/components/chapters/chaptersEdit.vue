<template>
    <div>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/chapters' }">课程章节</el-breadcrumb-item>
            <el-breadcrumb-item>编辑章节</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-form :model="chapter" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item prop="course_id" class="c_input">
                <el-input v-model="chapter.course_id" type="hidden"></el-input>
            </el-form-item>

            <el-form-item label="章节名称" prop="title">
                <el-input v-model="chapter.title"></el-input>
            </el-form-item>

            <el-form-item label="视频地址" prop="video">
                <el-input v-model="chapter.video"></el-input>
            </el-form-item>

            <el-form-item label="字幕" prop="caption">
                <el-input v-model="chapter.caption"></el-input>
            </el-form-item>

            <el-form-item label="时长" prop="time" style="margin-top: 20px;">
                <el-input v-model="chapter.time"></el-input>
            </el-form-item>

            <el-form-item label="排序" prop="sort">
                <el-input-number v-model="chapter.sort" :min="1" :max="99"></el-input-number>
            </el-form-item>

            <el-form-item label="免费">
                <el-radio-group size="medium" v-model="chapter.free">
                    <el-radio :label="1">是</el-radio>
                    <el-radio :label="0">否</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="发布">
                <el-radio-group size="medium" v-model="chapter.publish">
                    <el-radio :label="1">是</el-radio>
                    <el-radio :label="0">否</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="章节描述" prop="body" class="body_height">
                <quill-editor v-model="chapter.body" :options="editorOption"></quill-editor>
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
                chapter: {},
                editorOption:{
                    placeholder:'请输入文章内容...'
                },
                rules: {
                    title: [
                        {required: true, message: '请输入章节名称', trigger: 'blur'},
                        {min: 3, max: 30, message: '长度在 3 到 30 个字符', trigger: 'blur'}
                    ],
                    video: [
                        {required: true, message: '请输入视频地址', trigger: 'blur'}
                    ],
                    body: [
                        {required: true, message: '请填写章节内容', trigger: 'blur'}
                    ]
                }
            };
        },
        created() {
            this.init();
        },
        methods: {
            init() {
                //设置课程的id
                this.chapter.course_id = this.$route.params.course_id
                //获取章节id
                let id = this.$route.params.id
                axios.get(`/admin/chapters/${id}/edit`)
                    .then((res)=>{
                        //console.log(res)
                        this.chapter = res.data
                    })
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.put(`/admin/chapters/${this.chapter.id}`, this.chapter)
                            .then((res) => {
                                this.$notify({
                                    title: '成功',
                                    message: '新增章节成功',
                                    type: 'success'
                                });
                                this.$router.go(-1);
                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
        }
    }
</script>

<style>
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

    .demo-ruleForm {
        margin: 30px 0;
    }

    .hengxian {
        margin-top: 20px;
        border-top: 1px solid #eeeeee;
    }

    .el-tag {
        margin: 0 2px 5px;
    }

    .el-form-item__label {
        width: 100px;
    }
    .c_input{
        margin-top: -50px;
    }

</style>