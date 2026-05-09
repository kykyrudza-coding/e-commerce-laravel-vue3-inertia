<template>
    <div class="flex items-end h-full justify-center">
        <div class="bg-white w-[35rem] 2xl:mr-[50rem] xl:mr-[40rem] lg:mr-[25rem] h-2/3 rounded-t-lg shadow-2xl">
            <form @submit.prevent="handleLogin" class="p-10">
                <!--headline-->
                <Headline text="Welcome back" />

                <!--Email address input-->
                <InputWithIcon
                    v-model="form.email"
                    id="email"
                    name="email"
                    type="email"
                    placeholder="name@domen.com"
                    :error="errors.email"
                >
                    <template #icon>
                        <i class="ri-mail-line"></i>
                    </template>
                </InputWithIcon>

                <!--Password input-->
                <InputWithIcon
                    v-model="form.password"
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Password"
                    :error="errors.password"
                >
                    <template #icon>
                        <i class="ri-lock-2-line"></i>
                    </template>
                </InputWithIcon>

                <!--Forgot password link-->
                <a to="javascript:" class="text-indigo-600 text-base font-medium leading-6">
                    <UnderLineLink text="Forgot your password" to="password.request" />
                </a>

                <!--Login btn-->
                <div class="flex mt-7 mb-5">
                    <BasicButton text="LOGIN" type="submit"/>
                </div>

                <!--Signup link-->
                <a to="javascript:"
                   class="flex justify-between text-gray-900 text-base font-medium leading-6"> Don't have an account?
                    <span class="text-indigo-600 font-semibold pl-3">
                        <UnderLineLink text="Create your account" @click="switchToRegister" />
                    </span>
                </a>
            </form>
        </div>
    </div>
</template>

<script>
import { useForm } from '@/services/spaCompat';
import UnderLineLink from "@/Components/Links/UnderLineLink.vue";
import Headline from "@/Components/Forms/Headline.vue";
import InputWithIcon from "@/Components/Forms/InputWithIcon.vue";
import BasicButton from "@/Components/Forms/BasicButton.vue";

export default {
    name: 'LoginForm',
    components: {
        BasicButton,
        InputWithIcon,
        Headline,
        UnderLineLink
    },
    props: {
        errors: {
            type: Object,
            default: () => ({})
        }
    },
    setup() {
        const form = useForm({
            email: '',
            password: ''
        });

        return { form };
    },
    methods: {
        switchToRegister() {
            this.$emit('switch-form', 'register');
        },
        switchToForgotPassword() {
            this.$emit('switch-form', 'forgot-password');
        },
        handleLogin() {
            this.form.post(route('login'), {
                preserveState: true,
                preserveScroll: true,
            });
        }
    }
};
</script>
