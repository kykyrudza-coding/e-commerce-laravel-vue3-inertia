<template>
    <div class="flex items-end h-full justify-center">
        <div class="bg-white w-[35rem] 2xl:-mr-[50rem] xl:-mr-[40rem] lg:-mr-[25rem] h-2/3 rounded-t-lg shadow-2xl">
            <form @submit.prevent="handleRegister" class="p-10">
                <!-- Headline -->
                <Headline text="Create Your Account" />

                <!-- Name input -->
                <InputWithIcon
                    v-model="form.name"
                    id="name"
                    name="name"
                    type="text"
                    placeholder="Your name"
                    :error="errors.name"
                >
                    <template #icon>
                        <i class="ri-user-3-fill"></i>
                    </template>
                </InputWithIcon>

                <!-- Phone input -->
                <PhoneInput :error="errors.phone" v-model="form.phone">
                    <template #icon>
                        <i class="ri-phone-line"></i>
                    </template>
                </PhoneInput>

                <!-- Email input -->
                <InputWithIcon
                    v-model="form.email"
                    id="email"
                    name="email"
                    type="email"
                    placeholder="name@domain.com"
                    :error="errors.email"
                >
                    <template #icon>
                        <i class="ri-mail-line"></i>
                    </template>
                </InputWithIcon>

                <!-- Password input -->
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

                <!-- Password Confirmation input -->
                <InputWithIcon
                    v-model="form.password_confirmation"
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="Password Confirmation"
                    :error="errors.password_confirmation"
                >
                    <template #icon>
                        <i class="ri-lock-2-line"></i>
                    </template>
                </InputWithIcon>

                <!-- Register button -->
                <div class="flex mt-7 mb-5">
                    <BasicButton text="REGISTER" type="submit"/>
                </div>

                <!-- Login link -->
                <a to="javascript:" @click="switchToLogin"
                   class="flex justify-between text-gray-900 text-base font-medium leading-6"> Already signed up?
                    <span class="text-indigo-600 font-semibold pl-3">
                        <UnderLineLink text="Login" />
                    </span>
                </a>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@/services/spaCompat';
import InputWithIcon from "../../../Components/Forms/InputWithIcon.vue";
import Headline from "../../../Components/Forms/Headline.vue";
import UnderLineLink from "../../../Components/Links/UnderLineLink.vue";
import BasicButton from "../../../Components/Forms/BasicButton.vue";
import PhoneInput from "../../../Components/Forms/PhoneInput.vue";

const props = defineProps({
    errors: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['switch-form']);

const form = useForm({
    name: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const switchToLogin = () => {
    emit('switch-form', 'login');
};

const handleRegister = () => {
    form.post(route('register.store'), {
        preserveState: true,
        preserveScroll: true
    });
};
</script>
