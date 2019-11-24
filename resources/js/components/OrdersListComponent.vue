<template>
	<div class="container">
		<div class="card" v-for="order in orders">
			<div class="card-header">{{ order.title }}</div>
			<div class="card-body">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<form @submit.prevent="submit(order)">
								<div class="form-group row">
									<label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
									<div class="col-md-6">
										{{ order.title }}
									</div>
								</div>
								<div class="form-group row">
									<label for="description"
									       class="col-md-4 col-form-label text-md-right">Description</label>
									<div class="col-md-6">
										{{ order.description }}
									</div>
								</div>
								<div class="form-group row" v-if="order.image">
									<label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
									<div class="col-md-6">
										<img :src="order.image" :alt="order.title" class="rounded"
										     style="max-width: 500px"><!-- знаю что плохо, но не хочу со стилями возиться -->
									</div>
								</div>
								<div class="form-group row">
									<label for="title" class="col-md-4 col-form-label text-md-right">Status</label>
									<div class="col-md-6">
										<select v-model="order.status" :disabled="!order.isEditable">
											<option value="1">Ожидает</option>
											<option value="2">В процессе</option>
											<option value="3">Заверешен</option>
											<option value="4">На удержании</option>
											<option value="5">Отменен</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label for="description"
									       class="col-md-4 col-form-label text-md-right">Comment</label>
									<div class="col-md-6">
										<textarea class="form-control" name="description" id="description" cols="10"
										          rows="5" v-if="order.isEditable">{{ order.comment  }}</textarea>
										<div class="col-form-label" v-else>
											{{ order.comment }}
										</div>
									</div>
								</div>
								<div class="form-group row mb-0 mt-5" v-if="order.isEditable">
									<div class="col-md-8 offset-md-4">
										<button type="submit" class="btn btn-primary">Update Order</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	mounted() {
		//TODO redirect login
		this.fetchOrders()
	},
	data() {
		return {
			orders: [],
		}
	},
	methods: {
		submit(order) {
			const request = {
				comment: order.comment
			};
			if (parseInt(order.status) !== 1) {
				request.status = order.status
			}
			axios.patch('/api/orders/' + order.id, request).then(({ data }) => {
		    this.fetchOrders()
			}).catch((error) => {
				console.log(error);
			})
		},
		fetchOrders() {
			axios
				.get('/api/orders')
				.then(({ data }) => {
					this.orders = data.body.collection
				}).catch(response => {
					//TODO унести в App.created()


		      window.location.href = '/login'; //TODO переписать на роутер
			})
	}
	},
}
</script>
