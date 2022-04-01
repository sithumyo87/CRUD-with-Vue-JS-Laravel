<template>
    <div class="container my-5">
        <div class="row justify-content-end mb-3">
            <div class="col-5">
                <button class="btn btn-primary mr-2" @click="create()">
                    <i class="fas fa-plus-circle p-1"></i>Create
                </button>
            </div>
            <div class="col-3">
                <form @submit.prevent="searchProduct">
                    <div class="input-group mb-3">
                        <input
                            v-model="search"
                            type="text"
                            class="form-control"
                            placeholder="Search"
                            aria-label="Search"
                            aria-describedby="basic-addon2"
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <form
                    @submit.prevent="isEdit ? update() : store()"
                >
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ isEdit ? "Edit Form" : "Create Form" }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input
                                    v-model="product.name"
                                    name="name"
                                    type="text"
                                    class="form-control"
                                />

                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <input
                                    v-model="product.price"
                                    type="number"
                                    class="form-control"
                                />
                                
                            </div>
                            <button class="btn btn-primary my-2" type="submit">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                                <button
                                    class="btn btn-sm btn-success"
                                    @click="edit(product)"
                                >
                                    <i class="fas fa-edit p-1"></i>Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-danger"
                                    @click="destroy(product.id)"
                                >
                                    <i class="fas fa-trash-alt p-1"></i>Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
export default {
    // components: {
    //     'Pagination': LaravelVuePagination
    // },

    name: "ProductComponent",
    data() {
        return {
            isEdit: false,
            fullPage: false,
            products: {},
            search: "",
            product: new Form({
                name: "",
                price: "",
            }),
        };
    },
    methods: {
        searchProduct() {
            axios
                .get("/api/product?search=" + this.search)
                .then((res) => {
                    console.log(res);
                    this.products = res.data;
                })
                .catch(error => {
                    this.$Progress.fail();
                });
        },
        view(page = 1) {
            this.$Progress.start();
           let loader = this.$loading.show({
                  // Optional parameters
                  container: this.fullPage ? null : this.$refs.formContainer,
                  canCancel: true,
                  onCancel: this.onCancel,
                });                
           
            axios
                .get("/api/product?page=" + page)
                .then((res) => {
                    console.log(res);
                    this.products = res.data;
                    loader.hide();
                })
                .catch((e) => {
                    this.$Progress.fail();
                    loader.hide();
                });
        },
        store() {
            axios.post("/api/product/",this.product)
            .then(
                this.view(),
                   Toast.fire({
                    icon: 'success',
                    title: 'created successfully'
                }),
                this.product = {
                    name: "",
                    price: "",
                })
        },
        edit(product) {
            this.isEdit = true;
            this.product.id = product.id;
            this.product.name = product.name;
            this.product.price = product.price;
        },
        create() {
            this.isEdit = false;
            this.product = {
                name: "",
                price: "",
            };
        },
        update() {
            axios
                .put(`/api/product/${this.product.id}`, this.product)
                .then((res) => {
                    this.view(),
                     Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                }),
                        (this.product = {
                            name: "",
                            price: "",
                        });
                });
        },
        destroy(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title:'Deleted Successfully',
                        icon:'success',
                    }
                    );
                      Toast.fire({
                    icon: 'success',
                    title: 'deleted successfully'
                })
                     axios.delete(`/api/product/${id}`)
                    .then(res => {
                        this.view();
                    })
                }
            });
            // if(! confirm('Are U Sure to delete')){
            //     return;
            // }
            // axios.delete(`/api/product/${id}`)
            // .then(res => {
            //     this.view();
            // })
        },
    },
    created() {
        this.view();
    },
};
</script>

<style></style>
