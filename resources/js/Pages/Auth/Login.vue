<template>
    <Head title="Log in"/>

    <BreezeValidationErrors class="mb-4"/>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <h1 class="text-4xl px-2 text-center mb-4" style="font-family: 'Poppins', sans-serif;">
        <!--                        DASHBOARD-->
        Log In
    </h1>

    <form @submit.prevent="submit">
        <div>
            <BreezeLabel for="email" value="Email" class="flex items-center justify-center"/>
            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                         autocomplete="username"/>
        </div>

        <div class="mt-8">
            <BreezeLabel for="password" value="Password" class="flex items-center justify-center"/>
            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                         autocomplete="current-password"/>
        </div>

        <div class="block mt-8">
            <label class="flex items-center justify-center">
                <BreezeCheckbox name="remember" v-model:checked="form.remember"/>
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-center mt-4">
            <Link v-if="canResetPassword" :href="route('password.request')"
                  class="underline text-sm text-gray-600 hover:text-gray-900">
                Forgot your password?
            </Link>
        </div>

        <div class="flex items-center justify-center mt-4">
            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log In
            </BreezeButton>
        </div>

        <div class="flex items-center justify-center mt-4">
            <Link :href="route('register')">
                Register
            </Link>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import Button from "@/Components/Button";

export default {
    layout: BreezeGuestLayout,

    components: {
        Button,
        BreezeButton,
        BreezeCheckbox,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                user: '',
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        }
    }
}
</script>
