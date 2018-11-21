<template>
    <div>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/courses' }">课程列表</el-breadcrumb-item>
            <el-breadcrumb-item>编辑课程</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-form :model="course" :rules="rules" ref="course" label-width="100px" class="demo-ruleForm">
            <el-form-item label="课程名称" prop="name">
                <el-input v-model="course.name"></el-input>
            </el-form-item>

            <el-form-item label="课程价格" prop="price">
                <el-input-number v-model.number="course.price" :min="0" :max="20"></el-input-number>
            </el-form-item>

            <el-form-item label="缩略图" prop="photo_id">

                <el-upload
                        action="/photos"
                        list-type="picture-card"
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :on-success="handleSuccess"
                        :file-list="fileList">
                    <i class="el-icon-plus"></i>
                </el-upload>

                <el-dialog :visible.sync="dialogVisible">
                    <img width="100%" :src="course.photo_id" alt="">
                </el-dialog>

            </el-form-item>


            <div>选择课程标签</div>

            <el-table class="b_over" :data="course_nodes" style="width: 100%;margin-top: -5px;">

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
                <el-button type="primary" @click="submitForm('course')">立即创建</el-button>
                <el-button @click="resetForm('course')">重置</el-button>
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
                course: {},
                fileList: [],
                dialogVisible: false,
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
                },
            };
        },
        created() {
            //每个分类对应的所有标签
            axios.get(`/admin/overviews`)
                .then((res) => {
                    this.course_nodes = res.data
                })

            //当前要编辑的课程
            let id = this.$route.params.id;
            axios.get(`/admin/courses/${id}/edit`)
                .then((res) => {
                    console.log(res)
                    this.course = res.data.course
                    let tag_id = res.data.course.course.map(item => {
                        return item.id
                    })
                    this.tag_id = tag_id;
                    this.fileList = [{name: res.data.course.photo.image, url: res.data.course.photo.image}];
                })
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        delete this.course.course;
                        delete this.course.photo;
                        this.course.tag_id = this.tag_id;
                        axios.put(`/admin/courses/${this.course.id}`, this.course)
                            .then((res) => {
                                this.$notify({
                                    title: '成功',
                                    message: '编辑课程成功',
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
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePictureCardPreview(file) {
                this.image = file.image;
                this.dialogVisible = true;
            },
            handleSuccess(response, file, fileList) {
                this.course.image = response.image_url;
                this.course.photo_id = response.photo_id;
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

    .el-tag{
        float: left;
        margin:5px 5px;
    }
</style>