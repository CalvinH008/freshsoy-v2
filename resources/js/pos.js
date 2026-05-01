export function productForm(initialVariants = []){
    return {
        variants: initialVariants,
        addVariant(){
            this.variants.push({
                size:'', 
                price:''
            })
        },

        removeVariant(index){
            this.variants.splice(index, 1)
        },
    }
}