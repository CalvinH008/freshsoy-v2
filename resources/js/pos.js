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
            console.log('outlet_id', this.outletId)
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

        get change(){
            return this.amountPaid >= this.total ? this.amountPaid - this.total : 0
        },

        showModal: false,
        amountPaid: 0,
    };
}
