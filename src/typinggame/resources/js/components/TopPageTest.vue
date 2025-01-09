<template>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="form-row justify-content-center">
                <div class="col-md-3 mb-4">
                    <select class="custom-select custom-select-sm" v-model="selectCategoryId">
                        <option :value="null" disabled>Select Category</option>
                        <option v-for="(category, index) in categories" :key="index" :value="index + 1">{{ category.category_name }}</option>
                    </select>
                </div>
                <div class="col-md-3 mb-4">
                    <select class="custom-select custom-select-sm" v-model="selectDifficultyId">
                        <option :value="null" disabled>Select Difficulty</option>
                        <option value="1">★☆☆☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="4">★★★★☆</option>
                        <option value="5">★★★★★</option>
                    </select>
                </div>
                <div class="col-md-1 mb-4">
                    <button style="width: 100%" class="btn btn-sm btn-outline-secondary" @click="ressetting">clear</button>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card mb-3" v-for="(list, index) in sortedLists" :key="index">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">{{ list.title }}</h5>
                                        <p class="card-text">
                                            <span class="badge badge-pill badge-success mr-2">{{ numberToCategory(list.category_id) }}</span>
                                            <img :src="numberToDifficulty(list.difficulty)">
                                        </p>
                                        <p class="card-text">
                                            HighScore: {{ list.high_score }}({{ list.high_score_user_id === null ? 'Guest' : list.score_user.name }})
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text d-flex justify-content-end">
                                            Made by {{ list.user.name }}
                                        </p>
                                        <a :href="'/drills/show/' + list.id" class="btn btn-primary float-right">Play</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="loading-animation pt-4" v-if="itemLoading">
            <img src="/img/loading.gif">
        </div>
    </div>
        <!-- ローディングアニメーション -->
</template>

<script>
    export default {
        props: {
            categories: {
                type: Array
            },
        },
        data: function() {
            return {
                selectCategoryId: null,
                selectDifficultyId: null,
                itemLoading: false,
                load: true,
                page: 1,
                drills: [],
            }
        },
        computed: {
            sortedLists: function() {
                let lists = this.drills.slice();

                if(this.selectCategoryId) {
                    lists = lists.filter( list => {
                        return list.category_id === this.selectCategoryId;
                    });
                }

                if(this.selectDifficultyId) {
                    lists = lists.filter( list => {
                        return list.difficulty == this.selectDifficultyId;
                    })
                }
                return lists;
            },
            numberToCategory: function () {
                return function (str) {
                    for(let i = 0; i < this.categories.length; i++) {
                        if(str === this.categories[i].id) {
                            return this.categories[i].category_name;
                        }
                    }
                };
            },
            numberToDifficulty: function () {
                return function (str) {
                    for(let i = 0; i < this.drills.length; i++) {
                        if(str == this.drills[i].difficulty) {
                            return `/img/star${str}.gif`;
                        }
                    }
                };
            },

        },
        methods: {
            ressetting: function () {
                this.selectCategoryId = null;
                this.selectDifficultyId = null;
            },
            clearVar() {
                this.itemLoading = false
                this.load = true
                this.page = 1
                this.drills = []
            },
            async getItems() {
                if (this.load) {
                    if (!this.itemLoading) {
                        this.itemLoading = true
                        try {
                            const response = await axios.get('api/lists?page=' + this.page);
                            if (response.data.drills.last_page == this.page) this.load = false;
                            if (response.data.drills.data) {
                                await response.data.drills.data.forEach((n, i) => {
                                    this.drills.push(n)
                                })
                            }
                            this.page += 1;
                        } catch (e) {
                            console.log(e.response)
                            this.load = false
                            this.itemLoading = false
                        } finally {
                            this.itemLoading = false
                        }
                    }
                }
            },
        },
        mounted() {
            this.clearVar();
            window.addEventListener('scroll', _.throttle(() => {
                    let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight == document.documentElement.offsetHeight;
                    if (bottomOfWindow) this.getItems();
            }, 200, { trailing: true, leading: true }));
            this.getItems();
        },
    }
</script>

<style scoped lang="scss">
    .loading-animation {
         text-align: center;
        img {
            width: 40px;
        }
    }
</style>
