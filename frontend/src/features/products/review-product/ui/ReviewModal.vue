<template>
    <div class="fixed inset-0 flex justify-center items-center z-50 bg-black bg-opacity-50">
        <div class="relative bg-white p-6 rounded-lg w-full max-w-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Оставить отзыв</h2>
                <button @click="closeModal" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
            </div>

            <div v-if="!auth.user" class="text-center">
                <p class="text-red-500 mb-4">Чтобы оставить отзыв, пожалуйста, войдите в свой аккаунт.</p>
                <button @click="redirectToLogin"
                        class="py-2.5 px-6 bg-indigo-500 text-white rounded-lg">
                    Войти
                </button>
            </div>

            <div v-else>
                <div class="flex items-center gap-2 mb-4">
                    <span v-for="star in 5" :key="star"
                          @click="setRating(star)"
                          class="cursor-pointer text-2xl">
                        <i :class="star <= form.rating ? 'ri-star-s-fill text-yellow-500' : 'ri-star-s-fill text-gray-300'"></i>
                    </span>
                </div>

                <p v-if="formErrors.rating" class="text-red-500 text-sm mb-4">
                    {{ formErrors.rating }}
                </p>

                <textarea
                    v-model="form.review"
                    class="w-full border rounded-lg p-4 h-28 mb-2"
                    placeholder="Напишите ваш отзыв..."
                ></textarea>

                <p v-if="formErrors.review" class="text-red-500 text-sm mb-4">
                    {{ formErrors.review }}
                </p>

                <div class="flex justify-end gap-4">
                    <button @click="closeModal" class="py-2.5 px-6 text-sm rounded-lg bg-zinc-700 text-white cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-zinc-900">
                        Закрыть
                    </button>
                    <button @click="submitForm"
                            class="py-2.5 px-6 text-sm bg-indigo-500 text-white rounded-lg cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-indigo-700">
                        Отправить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'ReviewModal',
    props: {
        productId: {
            type: Number,
            required: true
        },
        auth: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: {
                rating: 0,
                review: ''
            },
            formErrors: {
                rating: '',
                review: ''
            },
        };
    },
    methods: {
        setRating(star) {
            this.form.rating = star;
            this.formErrors.rating = '';
        },
        submitForm() {
            this.formErrors = {
                rating: '',
                review: ''
            };

            if (!this.auth.user) {
                alert('Вы должны войти в аккаунт, чтобы оставить отзыв.');
                return;
            }

            const data = {
                rating: this.form.rating,
                review: this.form.review
            };

            axios.post(`/products/${this.productId}/review-add`, data)
                .then(response => {
                    alert('Отзыв успешно добавлен!');
                    this.$emit('close');
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        this.formErrors = {
                            rating: errors.rating ? errors.rating[0] : '',
                            review: errors.review ? errors.review[0] : ''
                        };
                    } else {
                        alert('Произошла ошибка. Пожалуйста, попробуйте снова.');
                    }
                });
        },
        closeModal() {
            this.$emit('close');
        },
        redirectToLogin() {
            window.location.href = '/login';
        }
    }
}
</script>
