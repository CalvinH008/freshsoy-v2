export function productForm(){
    return {
        variants: [],
        addVariant(){
            this.variants.push({size:'', price:''})
        },

        removeVariant(index){
            this.variants.splice(index, 1)
        },
    }
}