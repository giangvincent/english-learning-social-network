<template>
    <div class="flex mt-4">
        <div class="hidden md:block md:w-1/5"></div>
        <div class="w-full px-4 mb-10 md:my-6 md:px-6 lg:px-8 md:w-4/5">
            <fieldset
                class="flex flex-col relative mt-2 mb-6 p-3 rounded-lg bg-white shadow"
            >
                <legend
                    class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2"
                >
                    Đổi thông tin cơ bản
                </legend>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600">Tên đầy đủ</span>
                    <input
                        v-model="user.full_name"
                        placeholder
                        type="text"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600">Tên hiển thị</span>
                    <input
                        v-model="user.nick_name"
                        placeholder
                        type="text"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600">Email</span>
                    <input
                        v-model="user.email"
                        placeholder
                        readonly
                        type="text"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>

                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600"
                        >Giới thiệu ngắn</span
                    >
                    <textarea
                        placeholder
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                        v-model="user.bio"
                    ></textarea>
                </div>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600">Ngày sinh</span>
                    <input
                        v-model="user.birthday"
                        placeholder
                        type="date"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>
                <button
                    class="mt-3 text-lg font-semibold mx-auto text-white rounded-lg px-6 py-3 btn-hover gradient-black"
                    @click="callUpdateInfo()"
                >
                    <span v-if="!processUpload">Lưu thay đổi</span>
                    <div v-if="processUpload">
                        <loading-icon></loading-icon>
                    </div>
                </button>
            </fieldset>
            <fieldset
                class="flex flex-col relative my-6 p-3 rounded-lg shadow bg-white"
            >
                <legend
                    class="mx-2 font-bold rounded-lg bg-green-800 text-white p-2"
                >
                    Đổi cài đặt thông báo
                </legend>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600"
                        >Tài khoản Facebook</span
                    >
                    <input
                        placeholder
                        type="text"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>
                <button
                    class="mt-3 text-lg font-semibold mx-auto text-white rounded-lg px-6 py-3 btn-hover gradient-black"
                >
                    <span v-if="!processUpload">Lưu thay đổi</span>
                    <div v-if="processUpload">
                        <loading-icon></loading-icon>
                    </div>
                </button>
            </fieldset>
            <fieldset
                class="flex flex-col relative my-6 p-3 rounded-lg shadow bg-white"
            >
                <legend
                    class="mx-2 font-bold rounded-lg bg-red-600 text-white p-2"
                >
                    Đổi mật khẩu
                </legend>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600">Mật khẩu cũ</span>
                    <input
                        placeholder
                        type="password"
                        v-model="cur_password"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600">Mật khẩu mới</span>
                    <input
                        placeholder
                        type="password"
                        v-model="password"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>
                <div class="py-1">
                    <span class="px-1 text-sm text-gray-600"
                        >Xác nhận mật khẩu mới</span
                    >
                    <input
                        placeholder
                        type="password"
                        v-model="c_password"
                        class="text-md px-3 py-2 rounded-lg w-full placeholder-gray-600 shadow"
                    />
                </div>
                <button
                    class="mt-3 text-lg font-semibold mx-auto text-white rounded-lg px-6 py-3 btn-hover gradient-black"
                    @click="callChangePassword"
                >
                    <span v-if="!processUpload">Lưu thay đổi</span>
                    <div v-if="processUpload">
                        <loading-icon></loading-icon>
                    </div>
                </button>
            </fieldset>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import LoadingIcon from "../Icons/LoadingAnimate.vue";
export default {
    name: "user-setting",
    components: {
        LoadingIcon
    },
    data() {
        return {
            processUpload: false,
            cur_password: "",
            password: "",
            c_password: ""
        };
    },
    computed: {
        ...mapState({
            user: state => state.user.user
        })
    },
    mounted() {},
    methods: {
        ...mapActions([
            "UpdateInfo",
            "ChangePassword",
            "UpdateNotificationConn"
        ]),
        callUpdateInfo() {
            if (!this.processUpload) {
                this.processUpload = true;
                let self = this;

                this.UpdateInfo(this.user)
                    .then(res => {
                        console.log(res);
                        self.processUpload = false;
                    })
                    .catch(err => {
                        console.log(err);
                        self.processUpload = false;
                    });
            }
        },
        callChangePassword() {
            if (!this.processUpload) {
                this.processUpload = true;
                let self = this;
                let passData = {
                    cur_password: this.cur_password,
                    password: this.password,
                    c_password: this.c_password
                };

                this.ChangePassword(passData)
                    .then(res => {
                        console.log(res);
                        self.processUpload = false;
                    })
                    .catch(err => {
                        console.log(err);
                        self.processUpload = false;
                    });
            }
        }
    }
};
</script>
