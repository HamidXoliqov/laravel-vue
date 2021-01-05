<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">
                            Create Account
                        </h3>
                    </div>
                    <div class="card-body">
                        <form v-on:submit.prevent="register">
                            <div class="form-group">
                                <label class="small mb-1" for="name"
                                    >Enter full name</label
                                >
                                <input
                                    id="name"
                                    class="form-control py-4"
                                    type="text"
                                    v-model="user.name"
                                    placeholder="Enter full name"
                                    autocomplete="off"
                                    autofocus="autofocus"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="errors.name"
                                >
                                    {{ errors.name[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="email"
                                    >Email address</label
                                >
                                <input
                                    id="email"
                                    class="form-control py-4"
                                    type="email"
                                    v-model="user.email"
                                    aria-describedby="emailHelp"
                                    placeholder="Enter email address"
                                    autocomplete="off"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="errors.email"
                                >
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="password"
                                            >Password</label
                                        >
                                        <input
                                            class="form-control py-4"
                                            id="password"
                                            type="password"
                                            v-model="user.password"
                                            placeholder="Enter password"
                                            autocomplete="off"
                                        />
                                        <div
                                            class="invalid-feedback"
                                            v-if="errors.password"
                                        >
                                            {{ errors.password[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="small mb-1"
                                            for="password_confirmation"
                                            >Confirm Password</label
                                        >
                                        <input
                                            id="password_confirmation"
                                            class="form-control py-4"
                                            type="password"
                                            v-model="user.password_confirmation"
                                            placeholder="Confirm password"
                                            autocomplete="off"
                                        />
                                        <div
                                            class="invalid-feedback"
                                            v-if="errors.password_confirmation"
                                        >
                                            {{
                                                errors.password_confirmation[0]
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4 mb-0">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block"
                                >
                                    Create Account
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small">
                            <router-link to="/login">
                                Have an account? Go to login
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as auth from "../../services/auth_service";
export default {
    name: "Register",

    data() {
        return {
            user: {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            },

            errors: {}
        };
    },

    methods: {
        register: async function() {
            try {
                await auth.register(this.user);
                this.errors ={};
                this.$router.push('/login')
                this.flashMessage.success({
                    message: "Create Account successfully !",
                    time: 5000
                });

            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    case 500:
                        this.flashMessage.error({
                            message: error.response.data.message,
                            time: 5000
                        });
                        break;
                    default:
                        this.flashMessage.error({
                            message: "Some error occurrend, Please try again !",
                            time: 5000
                        });
                        break;
                }
            }
        }
    }
};
</script>
