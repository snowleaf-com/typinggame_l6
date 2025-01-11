<template>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="form-row justify-content-center">
                <div class="col-md-3 mb-4">
                    <select class="custom-select custom-select-sm" v-model="selectCategoryId">
                        <option :value="null" disabled>ジャンルで絞る</option>
                        <option v-for="(category, index) in categories" :key="index" :value="index + 1">{{ category.category_name }}</option>
                    </select>
                </div>
                <div class="col-md-3 mb-4">
                    <select class="custom-select custom-select-sm" v-model="selectDifficultyId">
                        <option :value="null" disabled>難易度で絞る</option>
                        <option value="1">★☆☆☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="4">★★★★☆</option>
                        <option value="5">★★★★★</option>
                    </select>
                </div>
                <div class="col-md-1 mb-4">
                    <button style="width: 100%" class="btn btn-sm btn-outline-secondary" @click="ressetting">クリア</button>
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
                                        <p class="card-text" v-if="list.high_score !== null">
                                            ハイスコア: {{ list.high_score }}({{ list.high_score_user_id === null ? 'Guest' : list.score_user.name }})
                                        </p>
                                        <p class="card-text" v-else>ハイスコア: まだプレイされていません</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text d-flex justify-content-end">
                                            作成者: {{ list.user.name }}
                                        </p>
                                        <a :href="'/drills/show/' + list.id" class="btn btn-primary float-right">ゲーム開始</a>
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
        <div ref="observerTarget" class="observer-target"></div>
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
                canLoad: true,
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
            async getItems() {
                if (!this.canLoad || this.itemLoading) return;
                this.itemLoading = true
                try {
                    const response = await axios.get('api/lists?page=' + this.page);
                    const data = response.data

                    // アイテムをリストに追加
                    this.drills = [...this.drills, ...data.drills.data];
                    // 最終ページに到達したらロードを停止
                    if (data.current_page >= data.last_page) {
                        this.canLoad = false;
                    } else {
                        this.page += 1; // 次のページに進む
                    }
                } catch (e) {
                    console.log(e.response)
                    this.canLoad = false
                    this.itemLoading = false
                } finally {
                    this.itemLoading = false
                }
            },
            setupIntersectionObserver() {
                const target = this.$refs.observerTarget; // 監視対象の要素
                if (!target) return;

                const options = {
                    root: null, // ビューポート全体を監視
                    rootMargin: '0px', // 余白を設定（例: '200px' で早めにロード）
                    threshold: 1.0 // 完全に見えたときにコールバック
                };

                // Intersection Observer のコールバック関数
                const observerCallback = (entries) => {
                    entries.forEach((entry) => {
                    if (entry.isIntersecting && this.canLoad) {
                        this.getItems(); // ターゲットが見えたらデータをロード
                    }
                    });
                };

                // Observerのインスタンスを作成
                const observer = new IntersectionObserver(observerCallback, options);

                // ターゲット要素を監視
                observer.observe(target);

                // コンポーネント破棄時に監視を解除
                this.$once('hook:beforeDestroy', () => {
                    observer.disconnect();
                });
            },
        },
        mounted() {
            this.getItems(); // 初回データロード
            this.setupIntersectionObserver(); // Intersection Observer を設定
        }
    };
</script>

<style scoped lang="scss">
    .loading-animation {
        text-align: center;
        img {
            width: 40px;
        }
    }
</style>