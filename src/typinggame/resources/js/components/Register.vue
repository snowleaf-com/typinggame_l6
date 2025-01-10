<template>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-7 text-center pb-3">問題を作成する</h1>
            <p class="text-center text-danger">問題６〜１０以外は入力必須項目です。<br>問題は英数字・記号・半角スペースのみです。</p>
            <form action="/store" method="post">
                <slot></slot>
                <div class="form-group row justify-content-center">
                    <label for="validationTitle" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">タイトル</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.title" type="text" :class="{'form-control': true, 'is-valid': checkValidation.title}" id="validationTitle" name="title" required>
                        <div class="invalid-feedback">
                            {{ errors.title }}
                        </div>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                    <label for="validationCategory" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">ジャンル</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <select v-model="newEvent.category" :class="{'custom-select': true, 'is-valid': checkValidation.category}" id="validationCategory" name="category_id" required>
                            <option value="">ジャンルを選択してください</option>
                            <option :value="c.id" v-for="c in categories" :key="c.id">{{ c.category_name }}</option>
                        </select>
                        <div class="invalid-feedback">
                            {{ errors.category_id }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationDifficulty" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">難易度</label>
                    <div class="d-flex col-md-7 col-sm-10 col-xs-12 align-items-center">
                        <input v-model="newEvent.difficulty" type="hidden" id="validationDifficulty" name="difficulty">
                        {{ checkDifficulty }}
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                    <label for="validationQuestion1" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題1</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question1" type="text" :class="{'form-control': true, 'is-valid': checkValidation.question1 }" id="validationQuestion1" name="question1" required>
                        <div class="invalid-feedback">
                            {{ errors.question1 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion2" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題2</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question2" type="text" :class="{'form-control': true, 'is-valid': checkValidation.question2}" id="validationQuestion2" name="question2" required>
                        <div class="invalid-feedback">
                            {{ errors.question2 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion3" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題3</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question3" type="text" :class="{'form-control': true, 'is-valid': checkValidation.question3}" id="validationQuestion3" name="question3" required>
                        <div class="invalid-feedback">
                            {{ errors.question3 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion4" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題4</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question4" type="text" :class="{'form-control': true, 'is-valid': checkValidation.question4}" id="validationQuestion4" name="question4" required>
                        <div class="invalid-feedback">
                            {{ errors.question4 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion5" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題5</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question5" type="text" :class="{'form-control': true, 'is-valid': checkValidation.question5}" id="validationQuestion5" name="question5" required>
                        <div class="invalid-feedback">
                            {{ errors.question5 }}
                        </div>
                    </div>
                </div>
                <div v-if="question6from10 === false" class="form-group row justify-content-center">
                    <label for="validationQuestion5" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label"></label>
                    <div class="col-md-7 col-sm-10 col-xs-12 d-flex align-items-center">
                        <a href="#" @click="inputContinue">６問目以降も入力する（任意）</a>
                    </div>
                </div>
                <template v-if="question6from10">
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion6" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題6</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question6" type="text" :class="{'form-control': true, 'is-valid': throughValidation.question6}" id="validationQuestion6" name="question6" :readonly="check6">
                        <div class="invalid-feedback">
                            {{ errors.question6 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion7" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題7</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question7" type="text" :class="{'form-control': true, 'is-valid': throughValidation.question7}" id="validationQuestion7" name="question7" :readonly="check7">
                        <div class="invalid-feedback">
                            {{ errors.question7 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion8" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題8</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question8" type="text" :class="{'form-control': true, 'is-valid': throughValidation.question8}" id="validationQuestion8" name="question8" :readonly="check8">
                        <div class="invalid-feedback">
                            {{ errors.question8 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion9" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題9</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question9" type="text" :class="{'form-control': true, 'is-valid': throughValidation.question9}" id="validationQuestion9" name="question9" :readonly="check9">
                        <div class="invalid-feedback">
                            {{ errors.question9 }}
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="validationQuestion10" class="mr-lg-3 mr-md-5 col-md-1 col-sm-10 col-form-label">問題10</label>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <input v-model="newEvent.question10" type="text" :class="{'form-control': true, 'is-valid': throughValidation.question10}" id="validationQuestion10" name="question10" :readonly="check10">
                        <div class="invalid-feedback">
                            {{ errors.question10 }}
                        </div>
                    </div>
                </div>
                </template>



                <div class="form-group row justify-content-center">
                    <div class="mx-auto col-md-2 col-sm-10 col-xs-12">
                        <button type="submit" class="btn-block btn btn-primary" :disabled="!checkValid">登録する</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
            props: ['categories', 'errors'],
        data() {
            return {
                question6from10: false,//６問目以降表示するかどうか
                newEvent: {//それぞれの入力フォーム初期値
                    title: '',
                    category: '',
                    difficulty: '',
                    question1: '',
                    question2: '',
                    question3: '',
                    question4: '',
                    question5: '',
                    question6: '',
                    question7: '',
                    question8: '',
                    question9: '',
                    question10: '',
                },
                checkValidation: {//必須項目
                    title: false,
                    category: false,
                    question1: false,
                    question2: false,
                    question3: false,
                    question4: false,
                    question5: false,
                },
                throughValidation: {//任意項目（入力があればバリデーションをかける）
                    question6: false,
                    question7: false,
                    question8: false,
                    question9: false,
                    question10: false,
                },
            }
        },
        watch: {
            'newEvent.title': function(value) { //タイトル入力バリデーション
                if(value !== '' && value.length <= 50) {
                    this.checkValidation.title = true
                } else {
                    this.checkValidation.title = false
                }
            },
            'newEvent.category': function(value) {//カテゴリーバリデーション
                if(value !== '') {
                    this.checkValidation.category = true
                } else {
                    this.checkValidation.category = false
                }
            },
            'newEvent.question1': function(value) {//質問バリデーション
                if(value !== '' && value.match(/^[\x20-\x7e]*$/) && value.length <= 70) {
                    this.checkValidation.question1 = true
                } else {
                    this.checkValidation.question1 = false
                }
            },
            'newEvent.question2': function(value) {//質問バリデーション
                if(value !== '' && value.match(/^[\x20-\x7e]*$/) && value.length <= 70) {
                    this.checkValidation.question2 = true
                } else {
                    this.checkValidation.question2 = false
                }
            },
            'newEvent.question3': function(value) {//質問バリデーション
                if(value !== '' && value.match(/^[\x20-\x7e]*$/) && value.length <= 70) {
                    this.checkValidation.question3 = true
                } else {
                    this.checkValidation.question3 = false
                }
            },
            'newEvent.question4': function(value) {//質問バリデーション
                if(value !== '' && value.match(/^[\x20-\x7e]*$/) && value.length <= 70) {
                    this.checkValidation.question4 = true
                } else {
                    this.checkValidation.question4 = false
                }
            },
            'newEvent.question5': function(value) {//質問バリデーション
                if(value !== '' && value.match(/^[\x20-\x7e]*$/) && value.length <= 70) {
                    this.checkValidation.question5 = true
                } else {
                    this.checkValidation.question5 = false
                }
            },
            'newEvent.question6': function(value) {//質問バリデーション（任意なので、入力があったらの条件）
                if(value !== '') {
                    if (value.match(/^[\x20-\x7e]*$/) && value.length <= 70) {
                        this.throughValidation.question6 = true
                    } else {
                        this.throughValidation.question6 = false
                    }
                } else {
                    this.throughValidation.question6 = false
                }
            },
            'newEvent.question7': function(value) {//質問バリデーション（任意なので、入力があったらの条件）
                if(value !== '') {
                    if (!value.match(/^[\x20-\x7e]*$/) || value.length > 70) {
                        this.throughValidation.question7 = false
                    } else {
                        this.throughValidation.question7 = true
                    }
                } else {
                    this.throughValidation.question7 = false
                }
            },
            'newEvent.question8': function(value) {//質問バリデーション（任意なので、入力があったらの条件）
                if(value !== '') {
                    if (!value.match(/^[\x20-\x7e]*$/) || value.length > 70) {
                        this.throughValidation.question8 = false
                    } else {
                        this.throughValidation.question8 = true
                    }
                } else {
                    this.throughValidation.question8 = false
                }
            },
            'newEvent.question9': function(value) {//質問バリデーション（任意なので、入力があったらの条件）
                if(value !== '') {
                    if (!value.match(/^[\x20-\x7e]*$/) || value.length > 70) {
                        this.throughValidation.question9 = false
                    } else {
                        this.throughValidation.question9 = true
                    }
                } else {
                    this.throughValidation.question9 = false
                }
            },
            'newEvent.question10': function(value) {//質問バリデーション（任意なので、入力があったらの条件）
                if(value !== '') {
                    if (!value.match(/^[\x20-\x7e]*$/) || value.length > 70) {
                        this.throughValidation.question10 = false
                    } else {
                        this.throughValidation.question10 = true
                    }
                } else {
                    this.throughValidation.question10 = false
                }
            },
        },
        computed: {
            checkDifficulty() {//難易度を計算して表示させる
                let count = 0
                count += this.newEvent.question1.length
                count += this.newEvent.question2.length
                count += this.newEvent.question3.length
                count += this.newEvent.question4.length
                count += this.newEvent.question5.length
                count += this.newEvent.question6.length
                count += this.newEvent.question7.length
                count += this.newEvent.question8.length
                count += this.newEvent.question9.length
                count += this.newEvent.question10.length
                if(count === 0) {
                    return '自動で判定します'
                } else if(count < 40) {
                    this.newEvent.difficulty = 1
                    return '★☆☆☆☆'
                } else if(count >= 40 && count < 70) {
                    this.newEvent.difficulty = 2
                    return '★★☆☆☆'
                } else if(count >= 70 && count < 100) {
                    this.newEvent.difficulty = 3
                    return '★★★☆☆'
                } else if(count >= 100 && count < 200) {
                    this.newEvent.difficulty = 4
                    return '★★★★☆'
                } else if(count >= 200) {
                    this.newEvent.difficulty = 5
                    return '★★★★★'
                }
            },
            checkValid() {
                /*
                 * 必須項目のバリデーションチェックを行っている。
                 * 質問の６問目以降は入力があったらチェックを行う。
                 * これは投稿ボタンの表示・非表示に関与している
                 */
                let valid = true
                for(let key in this.checkValidation) {
                    if(!this.checkValidation[key]) {
                        valid = false
                    }
                }
                if(this.newEvent.question6 !== '') {
                    if(!this.throughValidation.question6) {
                        valid = false
                    }
                }
                if(this.newEvent.question7 !== '') {
                    if(!this.throughValidation.question7) {
                        valid = false
                    }
                }
                if(this.newEvent.question8 !== '') {
                    if(!this.throughValidation.question8) {
                        valid = false
                    }
                }
                if(this.newEvent.question9 !== '') {
                    if(!this.throughValidation.question9) {
                        valid = false
                    }
                }
                if(this.newEvent.question10 !== '') {
                    if(!this.throughValidation.question10) {
                        valid = false
                    }
                }
                return valid
            },
            checkValid5() {
                /*
                 * 必須項目までのバリデーションが済んでいるかどうかをチェックしている
                 * これにより、６問目のフォーム表示非表示を判断する
                 */
                let valid = true
                for(let key in this.checkValidation) {
                    if(!this.checkValidation[key]) {
                        valid = false
                    }
                }
                return valid
            },

            check6() {
                /*
                 * ５問目までバリデーションが通っていれば６問目を表示する
                 */
                if(!this.checkValid5){
                    return true
                }
                return false
            },
            check7() {
                /*
                 * ６問目のチェック（５問目までのバリデーションが通ってるかどうか）で、
                 * trueなら６問目が表示されない、falseなら６問目は表示されている
                 * ７問目はfalse＝６問目が表示されている時且つ６問目のバリデーションが通っている時に入力できるようになる
                 * つまり、入力できるのは、６問目がtrueの時且つcheck6がfalseの時（６問目が入力できる時）
                 */
                if(this.check6 || !this.throughValidation.question6) {
                    return true
                }
                return false
            },
            check8() {
                if(this.check7 || !this.throughValidation.question7) {
                    return true
                }
                return false
            },
            check9() {
                if(this.check8 || !this.throughValidation.question8) {
                    return true
                }
                return false
            },
            check10() {
                if(this.check9 || !this.throughValidation.question9) {
                    return true
                }
                return false
            },
        },
        methods: {
            inputContinue(e) {//６問目以降表示するボタン
                e.preventDefault()
                this.question6from10 = true
            }
        }
    }
</script>
