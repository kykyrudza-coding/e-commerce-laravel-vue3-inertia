
<template>
    <section class="py-24 relative">
        <div class="w-full flex-col justify-start items-center lg:gap-12 gap-10 inline-flex">
            <div class="w-full flex-col justify-start items-center gap-3 flex">
                <h2 class="w-full text-center text-gray-900 text-4xl font-bold font-manrope leading-normal">Як це працює</h2>
                <p class="max-w-2xl text-center text-gray-400 text-base font-normal leading-relaxed">Крок за кроком про процес покупки та доставки, щоб ви могли легко зрозуміти, як користуватися нашим сервісом та отримувати товар без зайвих турбот.</p>
            </div>
            <div class="w-full justify-start items-start gap-8 grid md:grid-cols-3 grid-cols-1">
                <div class="w-full flex-col justify-start items-start gap-2.5 inline-flex">
                    <div class="w-full flex justify-between relative">
                        <h4 class="text-gray-900 text-xl font-semibold leading-8">Оформлення замовлення</h4>
                        <h3 class="text-gray-100 text-7xl font-extrabold font-manrope leading-[100px] absolute -top-9 right-0">1</h3>
                    </div>
                    <p class="text-gray-400 text-base font-normal leading-relaxed">Оберіть товар на нашому сайті, додайте його до кошика та заповніть всі необхідні дані для доставки. Легко та зручно, без зайвих кроків.</p>
                </div>
                <div class="w-full flex-col justify-start items-start gap-2.5 inline-flex">
                    <div class="w-full flex justify-between relative">
                        <h4 class="text-gray-900 text-xl font-semibold leading-8">Підтвердження та оплата</h4>
                        <h3 class="text-gray-100 text-7xl font-extrabold font-manrope leading-[100px] absolute -top-9 right-0">2</h3>
                    </div>
                    <p class="text-gray-400 text-base font-normal leading-relaxed">Після підтвердження вашого замовлення вам потрібно вибрати спосіб оплати. Для вашої зручності ми підтримуємо систему PayPal для безпечних і швидких транзакцій.</p>
                </div>
                <div class="w-full flex-col justify-start items-start gap-2.5 inline-flex">
                    <div class="w-full flex justify-between relative">
                        <h4 class="text-gray-900 text-xl font-semibold leading-8">Доставка та отримання</h4>
                        <h3 class="text-gray-100 text-7xl font-extrabold font-manrope leading-[100px] absolute -top-9 right-0">3</h3>
                    </div>
                    <p class="text-gray-400 text-base font-normal leading-relaxed">Після обробки замовлення ми здійснюємо доставку в обраний вами спосіб. Ви отримаєте товар вчасно та в ідеальному стані, готовим до використання!</p>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
export default {
    name: "Steps"
}
</script>
