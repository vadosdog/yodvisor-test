<template>
	<form @submit.prevent="submit">
		<div class="alert alert-danger" role="alert" v-if="unauthorized">
			Неверная пара логин-пароль
		</div>
		<div class="form-group row">
			<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
			<div class="col-md-6">
				<input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus
				       v-model="fields.email" @input="clearUnauthorized()">
				<div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
			</div>
		</div>

		<div class="form-group row">
			<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

			<div class="col-md-6">
				<input id="password" type="password" class="form-control" name="password" required
				       autocomplete="current-password" v-model="fields.password" @input="clearUnauthorized()">
				<div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
			</div>
		</div>

		<div class="form-group row mb-0">
			<div class="col-md-8 offset-md-4">
				<button type="submit" class="btn btn-primary">
					Login
				</button>
			</div>
		</div>
	</form>
</template>

<script>
export default {
	data() {
		return {
			unauthorized: false,
			fields: {},
			errors: {},
		}
	},
	methods: {
		submit() {
			this.errors = {};
			axios.post('/api/auth/login', this.fields).then(({ data }) => {
				localStorage.setItem('token', `Bearer ${data.body.token}`)
				window.location.href = '/orders'; //TODO переписать на роутер
			}).catch((error) => {
				localStorage.removeItem('token')
				if (error.response.status === 422) {
					this.errors = error.response.data.error.details || {};
				} else if (error.response.status === 401) {
					this.unauthorized = true;
				}
			});
		},
		clearSuccess() {
			this.success = false
		},
		setImageField(event) {
			this.fields.image = event.target.files[0]
		},
		clearUnauthorized() {
			this.unauthorized = false;
		}
	},
}
</script>
