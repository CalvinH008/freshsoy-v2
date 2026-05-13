import axios from "axios";

export function productForm(initialVariants = []) {
    return {
        variants: initialVariants,
        addVariant() {
            this.variants.push({
                size: "",
                price: "",
            });
        },

        removeVariant(index) {
            this.variants.splice(index, 1);
        },
    };
}

export function posSystem(outletId = null) {
    return {
        products: [],
        cart: [],
        search: "",
        outletId: outletId,

        init() {
            console.log("outlet_id", this.outletId);
            this.getProduct();
        },

        async getProduct() {
            try {
                const result = await axios.get(
                    `/api/products?outlet_id=${this.outletId}`,
                );
                this.products = result.data.data;
                console.log("data dari backend", this.products);
            } catch (error) {
                console.log("error", error);
            }
        },

        addToCart(variant, productName) {
            const existing = this.cart.find(
                (item) => item.variantId === variant.id,
            );

            if (existing) {
                if (existing.quantity < variant.stock) {
                    // increment quantity
                    existing.quantity++;
                }
            } else {
                // push item baru
                this.cart.push({
                    variantId: variant.id,
                    name: productName,
                    size: variant.size,
                    price: Number(variant.price),
                    stock: Number(variant.stock),
                    quantity: 1,
                });
            }
        },

        removeFromCart(variantId) {
            this.cart = this.cart.filter(
                (item) => item.variantId !== variantId,
            );
        },

        get total() {
            return this.cart.reduce(
                (sum, item) => sum + item.price * item.quantity,
                0,
            );
        },

        showModal: false,
        amountPaid: 0,
        showReceipt: false,
        receipt: null,

        get change() {
            return this.amountPaid >= this.total
                ? this.amountPaid - this.total
                : 0;
        },

        async bayar(){
            try{
                const result = await axios.post('/cashier/order', {
                    outlet_id: this.outletId,
                    amount_paid: this.amountPaid,
                    cart: this.cart
                })
                if(result){
                    this.receipt = result.data
                    this.showReceipt = true
                    this.cart = []
                    this.amountPaid = 0
                    this.showModal = false
                }
            }catch(error){
                console.log('error' + error)
            }
        },
    };
}