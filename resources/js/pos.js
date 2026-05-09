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

export function posSystem() {
    return {
        products: [],
        cart: [],
        search: "",
        outletId: null,

        init() {
            this.getProduct();
        },

        async getProduct() {
            try {
                const result = await axios.get(
                    `api/products?outlet_id=${this.outletId}`,
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
                // increment quantity
                existing.quantity++;
            } else {
                // push item baru
                this.cart.push({
                    variantId: variant.id,
                    name: productName,
                    size: variant.size,
                    price: variant.price,
                    stock: variant.stock,
                    quantity: 1,
                });
            }
        },

        removeFromCart(variantId){
            this.cart = this.cart.filter(item => item.variantId !== variantId)
        },

        get total(){
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0)
        }
    };
}
