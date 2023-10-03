<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 left-content">
                    <!-- 左侧产品图片部分 -->
                    <img :src="currentImage" :alt="product.name" class="large-image"/>
                    <div class="small-images">
                        <div v-for="(image, index) in product.images" :key="index">
                            <img
                                :src="image"
                                :alt="product.name"
                                class="small-image"
                                @click="changeLargeImage(image)"
                                :class="{ 'selected': index === selectedImageIndex }"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-md-6 right-content">
                    <!-- 右侧产品信息和购买链接部分 -->
                    <h5 class="product-name">{{ product.name }}</h5>
                    <p class="product-description">{{ product.description }}</p>
                    <div class="product-prices">
                        <span class="discount">$ {{ product.discounted }}</span>
                        <span class="discount-tag"
                              style="margin-left: 10px;"> <!-- 使用 margin-left 来增加间距 -->
        {{ product.discount.style === "amount" ? "$" + product.discount.amount : product.discount.amount + "%" }}
    </span><br>
                        <span class="original-price"><del>{{ "$" + product.price }}</del></span>
                    </div>
                    <br/>
                    <div class="add-to-cart">
                        <div class="quantity-container">
                            <button class="quantity-button minus" @click="decrementQuantity" style="width: 40px;">-
                            </button>
                            <span class="selected-quantity">{{ selectedQuantity }}</span>
                            <button class="quantity-button plus" @click="incrementQuantity" style="width: 40px;">+
                            </button>
                        </div>
                        <button class="btn add-to-cart-button" style="width: 200px;">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import image1 from "./1.jpg"; // 使用 import 导入图片

export default {
    data() {
        return {
            product: {
                name: "Product Name",
                description: "Product Description",
                price: 100,
                discount: {
                    amount: 20,
                    style: "percentage",
                },
                discounted: 80,
                images: [
                    image1, // 使用导入的图片变量
                    image1,
                    image1,
                    image1,
                ],
            },
            currentImage: image1, // 使用导入的图片变量
            selectedQuantity: 1,
        };
    },

    methods: {
        incrementQuantity() {
            // 增加数量的逻辑
            this.selectedQuantity++;
        },
        decrementQuantity() {
            // 减少数量的逻辑
            if (this.selectedQuantity > 1) {
                this.selectedQuantity--;
            }
        },

        changeLargeImage(image, index) {
            this.currentImage = image;
            this.selectedImageIndex = index;
        },

    },
};
</script>

<style scoped>
/* 引入你的CSS文件，假设它叫做styles.css */
@import './style.css';
@import "~font-awesome/css/font-awesome.min.css";

/* Vue组件内的其他样式 */


/* 其他样式根据需要添加 */
</style>
