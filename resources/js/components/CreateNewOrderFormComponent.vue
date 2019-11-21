<template>
	<form @submit.prevent="submit">

		<div class="alert alert-success" role="alert" v-if="success">
			Успешно отправлено
		</div>
		<div class="form-group row">
			<label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
			<div class="col-md-6">
				<input id="title" type="text" class="form-control" name="title" v-model="fields.title" @input="clearSuccess()">
				<div v-if="errors && errors.title" class="text-danger">{{ errors.title[0] }}</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
			<div class="col-md-6">
				<textarea class="form-control" name="description" id="description" cols="30" rows="10"
				          v-model="fields.description" @input="clearSuccess()"></textarea>
				<div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
			<div class="col-md-6">
				<input id="image" type="file" class="form-control" name="image" @change="setImageField($event)" ref="fileInput">
				<div v-if="errors && errors.image" class="text-danger">{{ errors.image[0] }}</div>
			</div>
		</div>
		<div class="form-group row mb-0 mt-5">
			<div class="col-md-8 offset-md-4">
				<button type="submit" class="btn btn-primary">Create Order</button>
			</div>
		</div>
	</form>
</template>

<script>
export default {
	data() {
		return {
			fields: {},
			errors: {},
			success: false,
		}
	},
	methods: {
		submit() {
			this.errors = {};
			let formData = new FormData();
			if (this.fields.title) {
				formData.append('title', JSON.stringify(this.fields.title));
			}
			if (this.fields.description) {
				formData.append('description', JSON.stringify(this.fields.description))
			}
			if (this.fields.image) {
				formData.append('image', this.fields.image);
			}
			axios.post('/api/orders', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(response => {
				this.success = true;
				this.fields.title = '';
				this.fields.description = '';
				this.fields.image = '';
			  const input = this.$refs.fileInput
			  input.type = 'text'
			  input.type = 'file'
			}).catch((error) => {
				if (error.response.status === 422) {
					this.errors = error.response.data.error.details || {};
				}
			});
		},
		clearSuccess() {
			this.success = false
		},
		setImageField(event) {
			this.fields.image = event.target.files[0]
		}
	},
}
</script>
