<template>
    <div class="jumbotron jumbotron-fluid">
        <div class="container text-center">
            <h1 class="display-7 mx-auto pr-2">{{ drill[0].title }}</h1>
            <span class="d-inline-block badge badge-success mr-3">{{ drill[0].category.category_name }}</span><img :src="difficultyImagePath">
            <p>made by {{ drill[0].user.name }}</p>

            <div class="card-body text-center drill-body">
                <button class="btn btn-primary mt-3" @click="doDrill" v-if="!isStarted">
                    START
                </button>
                <p v-if="isCountDown" style="font-size: 100px;">
                    {{ countDownNum }}
                </p>
                <template v-if="isStarted && !isCountDown &&!isEnd">
                    <h2>{{ timerNum }}</h2>
                    <h2 style="font-size:70px; font-family: 'Courier New', monospace; word-break: break-all; width: 100%;">
                        {{ questionWords }}
                    </h2>
                    question number:<b>{{ currentQuestionNum + 1}}</b><br>
                    score:<b>{{ typingScore }}</b>
                </template>
                <template v-if="isEnd">
                    <h2>Your Score</h2>
                    <h2>{{ typingScore }}</h2>
                    <p v-if="userId > 0">スコアを登録しました</p>
                    <p v-else>ログインすればスコア管理ができます</p>
                    <p v-if="endTitle">{{ endTitle }}</p>
                    <p v-if="endTitle2">{{ endTitle2 }}</p>
                    <a :href="'/drills/show/' + this.drill[0].id"><button class="btn btn-success">Click Replay</button></a>
                </template>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            drill: {
                type: Array,
            },
            userId: {
                type: Number
            }
        },
        data: function() {
            return {
                endTitle: '',
                endTitle2: '',
                countDownNum: 3,
                timerNum: 30,
                missNum: 0,
                wpm: 0,
                isStarted: false,
                isEnd: false,
                isCountDown: false,
                currentWordNum: 0,
                currentQuestionNum: 0,
                totalQuestion: 0,
                difficultyImagePath: ''
            }
        },
        mounted() { //トータル問題数の計算
            let question = []
            for(let i = 0; i < 10; i++) {
                question.push(this.drill[0].questions[i].question)
            }
            let filterNullQuestion = question.filter(e => {
                return e !== ''
            });
            console.log(filterNullQuestion)

            this.totalQuestion = filterNullQuestion.length
            console.log(filterNullQuestion.length)

            this.setDifficultyImage();//難易度画像の表示
        },
        computed: {
            questionWords: function() {
                if(this.isEnd === false) {
                    let question = this.drill[0].questions[this.currentQuestionNum].question;
                    /*
                        +"questions": array:10 [▼
                            0 => {#291 ▼
                                +"id": 51
                                +"drill_id": 6
                                +"question": "a"
                                +"order": 1
                                +"created_at": "2025-01-10 21:54:35"
                                +"updated_at": "2025-01-10 21:54:35"
                            }
                    */
                    console.log(question);

                    let placeholder = '';
                    for (let i = 0; i < this.currentWordNum; i++) {
                        placeholder += '_';
                    }

                    return placeholder + question.slice(this.currentWordNum);
                }
            },
            totalWordsNum: function () {
                if (this.isEnd === false) {
                    //問題の総文字数を返す
                    return this.questionWords.length;
                }
            },
            typingScore: function () {
                //スコア
                let score = (this.wpm * 2) * (1 - this.missNum / (this.wpm * 2));
                return isNaN(score) ? 0 : score;
            },
        },
        methods: {
            doDrill: function () {
                //スタートボタン、カウントダウン開始させる
                this.isStarted = true;
                this.countDown()
            },
            countDown: function () {
                //カウントダウン画面
                this.isCountDown = true
                let timer = window.setInterval(() => {
                    this.countDownNum -= 1;

                    if(this.countDownNum <= 0) {
                        this.isCountDown = false
                        window.clearInterval(timer)
                        //０になったら問題のタイマーと、１問目を表示させる
                        this.countTimer()
                        this.showFirstQuestion()
                    }
                }, 1000)
            },
            showFirstQuestion: function () {
                const okSound = new Audio('../../sounds/keyboard3.mp3')
                const ngSound = new Audio('../../sounds/incorrect2.mp3')

                window.addEventListener('keypress', e => {
                    if (this.isEnd === true) {
                        e.preventDefault()
                        return
                    }
                    console.log(e.key);
                    if (e.key === this.questionWords[this.currentWordNum]) {
                        console.log('正解！')
                        this.soundPlay(okSound)
                        ++this.currentWordNum

                        ++this.wpm
                        console.log('現在回答の文字数目:' + this.currentWordNum)

                        if(this.totalWordsNum === this.currentWordNum) {
                            console.log('次の問題へ')
                            ++this.currentQuestionNum
                            this.currentWordNum = 0
                            if (this.totalQuestion === this.currentQuestionNum) {
                                this.isEnd = true
                                this.postHighScore()
                                this.postMyScore()
                            }
                        }
                    } else {
                        console.log('不正解')
                        this.soundPlay(ngSound)
                        ++this.missNum
                        console.log('現在回答の文字数目:' + this.currentWordNum)
                    }
                })
            },
            countTimer: function () {
                let timer = window.setInterval(() => {
                    this.timerNum -= 1
                    if(this.isEnd === true) {
                        window.clearInterval(timer)
                        console.log('カウントリセット')
                        return;
                    }
                    if (this.timerNum <= 0) {
                        this.postHighScore()
                        this.postMyScore()
                        this.isEnd = true
                        window.clearInterval(timer)
                    }
                }, 1000);
            },
            postHighScore: function () {
                //・ドリルのハイスコア（ハイスコアと、そのユーザーID）
                //現在あるカラムと比較して大きければ入れる
                if(this.userId === 0) {
                    let guestId = '';
                    const data = {
                        high_score: this.typingScore,
                        high_score_user_id: guestId
                    }
                    const url = `/api/drill/score/${this.drill[0].id}`;
                    axios.post(url, data)
                        .then( res => {
                            this.endTitle = res.data;
                        })
                        .catch(error => {
                            console.log(error);
                        })
                } else {
                    const data = {
                        high_score: this.typingScore,
                        high_score_user_id: this.userId
                    }
                    const url = `/api/drill/score/${this.drill[0].id}`;
                    axios.post(url, data)
                        .then( res => {
                            this.endTitle2 = res.data;
                        })
                        .catch(error => {
                            console.log(error);
                        })
                }

            },
            postMyScore: function () {
                //・個人のスコア記録（スコア、ユーザーID、drillID）
                //ログインしてる場合のみ。
                if(this.userId === 0) {
                    return;
                }
                const data = {
                    score: this.typingScore,
                    user_id: this.userId
                }
                const url = `/api/myscore/${this.drill[0].id}`;
                axios.post(url, data)
                    .then(res => {
                        this.endTitle = res.data;
                })
                .catch(error => {
                    console.log(error);
                })

            },
            soundPlay: function (sound) {
                sound.currentTime = 0
                sound.play()
            },
            setDifficultyImage() {
                const difficulty = this.drill[0].difficulty;
                this.difficultyImagePath = `/img/star${difficulty}.gif`;
            },

        }
    }
</script>
