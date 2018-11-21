<template>
    <div>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/courses' }">课程列表</el-breadcrumb-item>
            <el-breadcrumb-item>新增课程</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-form :model="course" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="课程名称" prop="name">
                <el-input v-model="course.name"></el-input>
            </el-form-item>

            <el-form-item label="课程价格" prop="price">
                <el-input-number v-model.number="course.price" :min="0" :max="20"></el-input-number>
            </el-form-item>

            <el-form-item label="缩略图" prop="photo_id">
                <el-upload
                        class="avatar-uploader"
                        action="/photos"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload"
                >
                    <img v-if="course.image" :src="course.image" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </el-form-item>

            <div>选择课程标签</div>

            <el-table :data="course_nodes" style="width: 100%;margin-top: -5px;">

                <el-table-column prop="name" width="160"></el-table-column>

                <el-table-column>
                    <template slot-scope="scope">
                        <el-tag v-for="tag in scope.row.tags" :key="tag.id" type="success" class="el-tag">
                            <el-checkbox :label="tag.id" v-model="tag_id">{{tag.name}}</el-checkbox>
                        </el-tag>
                    </template>
                </el-table-column>
            </el-table>

            <!--<el-form-item v-for="category in overviews" :label="category.name" :key="category.id">-->
            <!--<el-checkbox v-for="tag in category.tags" :label="tag.id" v-model="tag_id" :key="tag.id">-->
            <!--<el-tag type="success">{{tag.name}}</el-tag>-->
            <!--</el-checkbox>-->
            <!--</el-form-item>-->

            <el-form-item label="适合人群" prop="target" style="margin-top: 20px;">
                <el-input v-model="course.target"></el-input>
            </el-form-item>

            <el-form-item prop="target_body" style="margin-top: 20px;">
                <el-input type="textarea" v-model="course.target_body" placeholder="适合人群介绍"></el-input>
            </el-form-item>

            <!--<el-form-item label="是否推荐" prop="best" style="margin-top: 15px;">-->
            <!--<el-switch v-model="course.best"></el-switch>-->
            <!--</el-form-item>-->

            <!--<el-form-item label="是否发布" prop="publish">-->
            <!--<el-switch v-model="course.publish"></el-switch>-->
            <!--</el-form-item>-->

            <!--<el-form-item label="是否完结" prop="complete">-->
            <!--<el-switch v-model="course.complete"></el-switch>-->
            <!--</el-form-item>-->

            <el-form-item label="推荐">
                <el-radio-group size="medium" v-model="course.best">
                    <el-radio :label="1">是</el-radio>
                    <el-radio :label="0">否</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="发布">
                <el-radio-group size="medium" v-model="course.publish">
                    <el-radio :label="1">是</el-radio>
                    <el-radio :label="0">否</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="完结">
                <el-radio-group size="medium" v-model="course.complete">
                    <el-radio :label="1">是</el-radio>
                    <el-radio :label="0">否</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="课程内容" prop="body" class="body_height">
                <quill-editor v-model="course.body" :options="editorOption"></quill-editor>
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
                course_nodes: [],
                course: {
                    name: '',
                    price: 0,
                    target: '',
                    target_body: '',
                    body: '',
                    image: '',
                    best: 1,
                    publish: 1,
                    complete: 1,
                    photo_id: '',
                },
                tag_id: [],
                editorOption:{
                    placeholder:'请输入文章内容...'
                },
                rules: {
                    name: [
                        {required: true, message: '请输入课程名称', trigger: 'blur'},
                        {min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur'}
                    ],
                    tag_id: [
                        {required: true, message: '请选择酷站分类', trigger: 'change'}
                    ],
                    photo_id: [
                        {required: true, message: '请上传缩略图', trigger: 'change'}
                    ],
                    target: [
                        {required: true, message: '请填写适合人群', trigger: 'change'}
                    ],
                    target_body: [
                        {required: true, message: '请填写适合人群描述', trigger: 'blur'}
                    ],
                    body: [
                        {required: true, message: '请填写课程内容', trigger: 'blur'}
                    ]
                }
            };
        },
        created() {
            //每个分类对应的所有标签
            axios.get(`/admin/overviews`)
                .then((res) => {
                    this.course_nodes = res.data;
                })
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.course.tag_id = this.tag_id;
                        axios.post(`/admin/courses`, this.course)
                            .then((res) => {
                                this.$notify({
                                    title: '成功',
                                    message: '新增课程成功',
                                    type: 'success'
                                });
                                this.$router.push({name: 'courses'})
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
            handleAvatarSuccess(res, file) {
                this.course.image = res.image_url;
                this.course.photo_id = res.photo_id;
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            }
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

    .el-tag{
        float: left;
        margin:5px 5px;
    }
</style>