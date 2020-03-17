<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            /**
             * When Form is submitted.
             * @param e
             */
            handleSubmit(e) {
                e.preventDefault()
                if(this.password.length > 0) {
                    let email = this.email
                    let password = this.password

                    axios.post('api/login', {email, password})
                        .then(response => {
                            // If Auth is Success
                            let user = response.data.user
                            let isAdmin = user.isAdmin

                            // we save the access token and user data in localStorage so,
                            // we can access them across our app.
                            localStorage.setItem('bigStore.user', JSON.stringify(user))
                            localStorage.setItem('bigStore.jwt', response.data.token)

                            // We also emit a loggedIn event so the parent component can update as well.
                            // Lastly, we check if the user was sent to the login page from another page,
                            // then send the user to that page. If the user came to login directly,
                            // we check the user type and redirect the user appropriately.
                            if(localStorage.getItem('bigStore.jqt') != null) {
                                this.$emit('loggedIn')
                                if(this.$route.params.nextUrl != null) {
                                    this.$router.push(this.$route.params.nextUrl)
                                } else {
                                    this.$router.push((isAdmin === 1 ? 'admin' : 'dashboard'))
                                }
                            }
                        })
                        .catch(error => {
                            alert('No user found.');
                        });
                }
            }
        }
    }
</script>
