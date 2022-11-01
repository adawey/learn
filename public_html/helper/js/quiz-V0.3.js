var app = new Vue({
    el: '#app-1',
    data: {
        feedback: '',
        current_question_answer: '',

        question_answered_list: [],

        timeTaken: '',
        score: 0,
        topics: null, // original response from the server [{id: , name: }, ]

        package: quizAttr.package,
        max_questions_num: quizAttr.max_questions_num,
        img_link: '',
        make_exam: {
            taken: 0,
            text: 'Submit Exam'
        }, // exam has been taken or not
        ScoreMsg: '',
        scoreAnalysis: quizAttr.scoreAnalysis,
        scoreAnalysisByChapter: quizAttr.scoreAnalysisByChapter,
        flaged: [],
        time_left: 0,
        answer_cat: 2,
        toggle_list: 0,
        rate_value: 0,
        rate_sentance: '',
        user_review: '',

        saved_quiz_id: 0,
        feed1: '',
        feed2: '',
        feed3: '',
        feed4: '',
        topics_included_arr: quizAttr.topics_included_arr,
        // cx => custom exams
        cx_topic: 0,
        cx_checkedItems: [],
        cx_quiz: false,


        chapters_inc: quizAttr.chapters_inc,
        process_inc: quizAttr.process_inc,
        exams_inc: quizAttr.exams_inc,


        /** New Quiz */
        questions: [],
        seeAnswer: false,
        timer: new Timer(),
        tagify: null,
        changesFlag: false,
        current_question_number: 0,
        question_number: 0, // all question number
        question_answered: 0, // answered question number
        base_question_number: 0, // difference
        question_title_list: [],
        current_question_type_id: null,
        current_question_title: '',
        current_question_title_ar: '',
        current_question_feedback: '',
        current_question_choices: [],
        current_question_image: null,
        current_question_flag: false,
        current_question_correct_answers_required: 1,
        user_answers: {},

        /** current Question answers holders */
        multipleChoiceValue: '',
        multipleResponseValue: [],

        /** Language : set as Default for current page*/
        language: quizAttr.language,
        languages: [
            {'code': 'en', 'language': 'English'},
            {'code': 'ar', 'language': 'العربية'},
            {'code': 'fr', 'language': 'Français'},
        ],
        beingDragged: null,

        /** Single Question Time Taken to answer */
        last_q_answer_time_taken: 0,
        time_taken: 0,

        /** Quiz Info */
        package_id: quizAttr.package_id,
        topic_type: quizAttr.topic_type,
        topic_id: quizAttr.topic_id,
        start_from_: 1,

        /** Results */
        overallScore: 0,
        alpha: ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"],
        flagged_question_only: false,

        video_id: quizAttr.video_id,
        menuContent: null,
        explanation_id: quizAttr.explanation_id,
        examTimeMin: quizAttr.examTimeMin,

    },
    mounted(){
        document.onkeydown = function(e) {
            switch(e.which) {
                case 37: // left
                    app.prev();
                    break;

                case 38: // up

                    break;

                case 39: // right
                    app.next();
                    break;

                case 40: // down
                    break;

                default: return; // exit this handler for other keys
            }
            e.preventDefault(); // prevent the default action (scroll / move caret)
        };

        this.initTopic();


    },
    computed: {
        currentQuestionId: function(){
            return this.getCurrentQuestion().id;
        },
        /** Question Type Check */
        isMatchingToCenter: function(){
            return this.current_question_type_id == 5;
        },
        isFillInTheBlank: function(){
            return this.current_question_type_id == 4;
        },
        isMatchingToRight: function(){
            return this.current_question_type_id == 3;
        },
        isMultipleResponses: function(){
            return this.current_question_type_id == 2;
        },
        isMultipleChoice: function(){
            return this.current_question_type_id == 1;
        },
        /** current question Selected Answers count for multiple response and fill in blank */
        currentSelectedAnswersCount: function(){
            if(this.isFillInTheBlank || this.isMultipleResponses){
                return this.user_answers[this.getCurrentQuestion().id]
                    .answers.filter(function(row){
                        return row.selected;
                    }).length;
            }
            return 0;
        },

        selectedTopic: function(){
            if(this.cx_topic != ''){
                return (app.topics_included_arr.filter(function(ele) {return ele.key == app.cx_topic})[0].name);
            }else{
                return '';
            }
        },
        selectedTopicContent: function(){
            if(this.selectedTopic != ''){
                return (app.topics_included_arr.filter(function(ele) {return ele.key == app.cx_topic})[0].content);
            }else{
                return [];
            }
        }
    },
    methods: {
        updateCircle: function(event){
            console.log(event.target.nextSibling);
        },
        _initMoveContent: function() {
            if (typeof MoveContent !== 'undefined') {
                if (document.querySelector('#tableOfContentsMoveContent')) {
                    const filterMove = document.querySelector('#tableOfContentsMoveContent');
                    const targetSelectorFilter = filterMove.getAttribute('data-move-target');
                    const moveBreakpointFilter = filterMove.getAttribute('data-move-breakpoint');
                    const filterMoveContent = new MoveContent(filterMove, {
                        targetSelector: targetSelectorFilter,
                        moveBreakpoint: moveBreakpointFilter,
                        beforeMove: (placement) => {
                            // Called before clearing of the html and moving content. Good for destroying plugins.
                            if (this._contentsScrollbar) {
                                this._contentsScrollbar.destroy();
                            }
                        },
                        afterMove: (placement) => {
                            // Called after clearing of the html and moving content. Good for initializing plugins.
                            if (typeof OverlayScrollbars !== 'undefined') {
                                this._contentsScrollbar = OverlayScrollbars(document.querySelectorAll('.table-of-contents-scroll'), {
                                    scrollbars: {},
                                    overflowBehavior: {x: 'hidden', y: 'scroll'},
                                });
                            }
                            jQuery('#tableOfContentsModal').modal('hide');
                        },
                    });
                    return filterMoveContent;
                }
            }
        },
        initTopic: async function(){
            // const res = await this.initTopicRequest();
            // quizAttr.topics_included_arr = res;
            // this.topics_included_arr = res;
            // if(this.topics_included_arr[0].key == 'chapter'){
            //     this.chapters_inc = this.topics_included_arr[0].content;
            // }else if(this.topics_included_arr[0].key == 'process'){
            //     this.process_inc = this.topics_included_arr[0].content;
            // }else{
            //     this.exams_inc = this.topics_included_arr[0].content;
            // }
            // if(this.topics_included_arr[0].key != 'chapter')
            await this.loadTopic('chapter').then(async function(){
                console.log('chapters');
                await app.loadTopic('exam').then(async function(){
                    console.log('exams');
                    await setTimeout(function(){
                        app.menuContent = app._initMoveContent();
                        console.log('menu');
                    }, 100);
                });
            });


            // if(this.topics_included_arr[0].key != 'exam')


            // refresh menu


        },
        initTopicRequest: async function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizAttr.api.csrf
                }
            });

            return $.ajax ({
                type: 'POST',
                url: quizAttr.api.init_topic,
                data: {
                    package_id          : this.package_id,
                    topic_type          : quizAttr.topic_type,
                    topic_id            : quizAttr.topic_id,
                },
                error: function(res){
                    console.log('Error:', res);
                }
            });
        },
        renderDragCenterChoice: function(choice, target, sub_target){
            let answer = '';
            if(sub_target){
                answer = choice[target][sub_target];
                if(this.language != 'en'){
                    const answer_localized = choice[target].transcodes[sub_target+'_'+this.language];
                    answer = answer_localized ? answer_localized: answer;
                }
            }else{
                answer = choice[target];
                if(this.language != 'en'){
                    const answer_localized = choice.transcodes[target+'_'+this.language];
                    answer = answer_localized ? answer_localized: answer;
                }
            }
            return answer;
        },
        renderDragRightChoice: function(choice, target){
            let answer = choice[target];
            if(this.language != 'en'){
                const answer_localized = choice.transcodes[target+'_'+this.language];
                answer = answer_localized ? answer_localized: answer;
            }
            return answer;
        },
        /**
         * Fallback to English Language.
         * MultipleChoice | MultipleResponse | FillInTheBlank
         * @param choice
         * @returns {*|string|string}
         */
        renderChoice: function(choice){
            let answer = choice.answer;
            if(this.language != 'en'){
                const answer_localized = choice.transcodes['answer_'+this.language];
                answer = answer_localized ? answer_localized: answer;
            }
            return answer;
        },
        Confirmation: function(){
            swal({
                title: 'Are you sure you want to end the exam ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then(app.markExam);
        },
        markExam:async function(confirmation){
            /** Confirmation */
            if(confirmation.value != 1){
                return;
            }
            /** Toggle Loading */
            app.toggleLoading();
            /** Store current Question */
            if(!app.cx_quiz) {
                app.storeToDB();
            }
            /** Mark User Answers */
            app.markUserAnswers();
            /** deal with score analysis */
            /** group by chapter */
            userAnswersByChapters = app.groupBy(
                Object.values(app.user_answers)
                , 'chapter'
            );
            /** group by Process */
            userAnswersByProcess = app.groupBy(
                Object.values(app.user_answers)
                , 'process_group'
            );
            /** generate the results view */
            /** overall score */
            app.overallScore = Object.values(app.user_answers).filter(row => row.user_answer_is_correct).length / app.questions.length * 100;
            app.overallScore = Math.round(app.overallScore);
            if(app.overallScore > 75){
                this.ScoreMsg = '<h4 style="font-weight:bold">:'+quizAttr.translation.overallPerformance+'<b style="color:springgreen;">'+quizAttr.translation.passed+'</b></h4>You have passed the exam, congratulations.';
            }else{
                this.ScoreMsg = '<h4 style="font-weight:bold">'+quizAttr.translation.overallPerformance+': <b style="color:#DC143C;">'+quizAttr.translation.failed+'</b></h4>You have failed your exam, you must improve to get certified.';
            }
            /** Result by process */
            // for (const [process_group, user_answers_] of Object.entries(userAnswersByProcess)) {
            //     process_score = user_answers_.filter(row => row.user_answer_is_correct).length / user_answers_.length * 100;
            //     if(process_score <= 65){
            //         msg = '<i style="color: red;">'+quizAttr.translation.needImprove+'</i>';
            //     }else if(process_score > 65 && process_score < 75){
            //         msg = '<i style="color: red;">'+quizAttr.translation.belowTarget+'</i>';
            //     }else if(process_score >= 75 && process_score < 85){
            //         msg = '<i style="color: #999900;">'+quizAttr.translation.target+'</i>';
            //     }else if(process_score >= 85){
            //         msg = '<i style="color:green;">'+quizAttr.translation.aboveTarget+'</i>';
            //     }
            //     table_head = $("#table_head");
            //     table_head.append('<th style="text-align:center">'+process_group+'</th>');
            //     table_body = $("#table_body");
            //     table_body.append('<td style="text-align:center">'+msg+'</td>');
            // }
            /** Result by chapter */
            resultByChapterElement = $("#resultByChapter");
            html = '';
            for (const [chapter, user_answers_] of Object.entries(userAnswersByChapters)) {
                correctAnswersCount = user_answers_.filter(row => row.user_answer_is_correct).length;
                chapterScore = correctAnswersCount / user_answers_.length * 100;
                html += '<tr><td>'+chapter+'</td><td>'+user_answers_.length+'</td><td>'+correctAnswersCount+'</td><td>'+Math.round(chapterScore)+'</td></tr>';
            }
            resultByChapterElement.append(html);
            /** Result by Process */
            resultByProcessElement = $("#resultByProcess");
            html = '';
            for (const [process_group, user_answers_] of Object.entries(userAnswersByProcess)) {
                for(const answer_ of user_answers_){
                    if(answer_.user_answer_is_correct)
                        html += '<tr><td>'+answer_.question_number+'</td><td>'+ (answer_.chapter ?? '--') +'</td><td><i style="color:green">1</i></td></tr>';
                    else
                        html += '<tr><td>'+answer_.question_number+'</td><td>'+ (answer_.chapter ?? '--') +'</td><td><i style="color:red">0</td></tr>';
                }
            }
            resultByProcessElement.append(html);
            /** Send Store Request */
            if(!app.cx_quiz){
                res = await app.storeScore();
            }
            /** stop progress and display results */
            app.toggleLoading();
            app.toggleResult();

        },
        markUserAnswers: function(){
            for (const [question_id, user_answer] of Object.entries(app.user_answers)) {
                app.markUserAnswer(question_id);
            }
        },
        markUserAnswer: function(question_id){
            user_answer = app.user_answers[question_id];
            switch (user_answer.question_type_id) {
                case 1:
                    /** Multiple Choice */
                    if(user_answer.answer){
                        correct_answer = user_answer.answers.filter(row => row.is_correct)[0];
                        if(correct_answer.answer_id == user_answer.answer.answer_id){
                            app.questionResult(question_id, true);
                        }else{app.questionResult(question_id, false);}
                    }
                    break;
                case 2:
                /** Multiple Response */
                case 4:
                    /** Fill in the Blank */
                    answers_ = user_answer.answers.filter(row => {
                        return row.is_correct && row.selected;
                    });
                    if(answers_.length == user_answer.correct_answers_required){
                        app.questionResult(question_id, true);
                    }else{app.questionResult(question_id, false);}
                    break;
                case 3:
                    /** Matching Right */
                    wrong_answers_ = user_answer.right.filter(row => {
                        if(row.left){
                            return row.id != row.left.id;
                        }else{return true;}
                    });
                    if(wrong_answers_ == 0){
                        app.questionResult(question_id, true);
                    }else{app.questionResult(question_id, false);}
                    break;
                case 5:
                    /** Matching To Center */
                    wrong_answers_ = user_answer.center.filter(row => {
                        if(row.left.selected){
                            return row.left.left_sentence != row.correct_sentence;
                        }
                        if(row.right.selected){
                            return row.right.right_sentence != row.correct_sentence;
                        }
                        return true;
                    });
                    if(wrong_answers_ == 0){
                        app.questionResult(question_id, true);
                    }else{app.questionResult(question_id, false);}
                    break;
                default:
                    /** do nothing ^_^ */
                    break;
            }
        },
        storeScore:async function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizAttr.api.csrf
                }
            });
            if(app.last_q_answer_time_taken > 0){
                timeI = (app.time_taken - app.last_q_answer_time_taken);
            }else{
                timeI = app.time_taken;
            }
            app.last_q_answer_time_taken = app.time_taken;

            return $.ajax ({
                type: 'POST',
                url: quizAttr.api.scoreStore,
                data: {
                    totalScore      : app.overallScore,
                    question_num    : app.question_number,
                    package_id      : app.package_id,
                    topic_type      : app.topic_type,
                    topic_id        : app.topic_id,
                    time_left       : timeI,
                    user_answers    : app.optimizeScoreStoreRequest(),
                    part_id: quizAttr.api.part_id,
                },
                error: function(res){
                    swal({
                        title: 'This Page Needs to be Refresh !',
                        type: 'warning',
                        confirmButtonText: 'Ok',
                    }).then(function(){
                        window.location.reload();
                    });
                    console.log('Error:', res);
                }
            });
        },
        optimizeScoreStoreRequest: function(){
            optimizedUserAnswers = {};
            for (const [question_id, user_answer] of Object.entries(app.user_answers)) {
                switch (user_answer.question_type_id) {
                    case 1:
                    /** Multiple Choice */
                    case 2:
                    /** Multiple Response */
                    case 3:
                    /** Matching Right */
                    case 4:
                    /** Fill in the Blank */
                    case 5:
                        /** Matching To Center */
                        optimizedUserAnswers[question_id] = {
                            question_type_id: app.user_answers[question_id].question_type_id,
                            question_id: app.user_answers[question_id].question_id,
                            user_answer_is_correct: app.user_answers[question_id].user_answer_is_correct,
                        };
                        break;
                    default:
                        /** do nothing ^_^ */
                        break;
                }
            }
            return optimizedUserAnswers;
        },
        questionResult: function(question_id, value){
            app.user_answers[question_id].user_answer_is_correct = value;
        },
        storeToDB:async function(){
            if(this.changesFlag){

                res = await this.storeAnswerRequest();
                // console.log(res);
                app.saved_quiz_id = res.quiz_id;

                this.changesFlag = false;
            }
        },
        storeAnswerRequest:async function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizAttr.api.csrf
                }
            });

            if(app.last_q_answer_time_taken > 0){
                timeI = (app.time_taken - app.last_q_answer_time_taken);
            }else{
                timeI = app.time_taken;
            }
            app.last_q_answer_time_taken = app.time_taken;

            thisUserAnswer = {
                ...app.user_answers[app.currentQuestionId],
                answers: app.user_answers[app.currentQuestionId].answers.filter(i => i)
            };

            return $.ajax ({
                type: 'POST',
                url: quizAttr.api.saveForLaterOn,
                data: {
                    package_id          : app.package_id,
                    topic_type          : app.topic_type,
                    topic_id            : app.topic_id,
                    start_from_         : app.start_from_,
                    questions_number    : app.question_number,
                    question_id         : app.currentQuestionId,
                    user_answer         : thisUserAnswer,
                    time_left           : timeI,
                    answered_question_number    : app.answeredQuestionNumber(),
                    part_id: quizAttr.api.part_id,
                },
                error: function(res){
                    swal({
                        title: 'This Page Needs to be Refresh !',
                        type: 'warning',
                        confirmButtonText: 'Ok',
                    }).then(function(){
                        window.location.reload();
                    });
                    console.log('Error:', res);
                }
            });
        },
        initMatch: function(){
            const fills = document.querySelectorAll('.fill');
            const empties = document.querySelectorAll('.empty');
            for(const fill of fills){
                fill.addEventListener('dragstart', function(){
                    this.className += ' hold';
                    app.beingDragged = this;
                    setTimeout(() => this.className += ' invisible', 0);
                });
                fill.addEventListener('dragend', function(){
                    this.className = 'fill';
                }, false);
            }
            for(const empty of empties){
                empty.addEventListener('dragover', (e) => {
                    e.preventDefault();
                });
                empty.addEventListener('dragenter', function(){
                    this.className += ' hovered';
                });
                empty.addEventListener('dragleave', function(){
                    this.className = 'empty';
                });
                empty.addEventListener('drop', function(e){
                    this.className = 'empty';
                    if(this.hasAttribute('data-max')){
                        if(this.childElementCount
                            >= this.getAttribute('data-max')){
                            return;
                        }
                    }
                    if(this.hasAttribute('data-accept-id')){
                        if(this.getAttribute('data-accept-id')
                            != app.beingDragged.getAttribute('data-id')){
                            return;
                        }
                    }
                    this.append(app.beingDragged);
                    /** sync with History */
                    if(app.isMatchingToRight){
                        app.applyUserRightDrag(
                            app.beingDragged,
                            this,
                        );
                    }
                    if(app.isMatchingToCenter){
                        app.applyUserCenterDrag(
                            app.beingDragged,
                            this,
                        );
                    }
                });
            }
        },
        initTagify: function(whitelist, maxTags){
            var inputElm = document.querySelector('#fillInTheBlank');
            return new Tagify(inputElm, {
                enforceWhitelist: true,
                whitelist,
                maxTags
            });
        },
        prev: function(){
            /** Store Last Current Question Answer */
            if(!app.cx_quiz){
                this.storeToDB();
            }
            /** validation */
            if((app.current_question_number - 1) <= 0 ||
                app.current_question_number - 1 > app.question_number ||
                !app.questions.length){
                return;
            }
            /** push question */
            this.push_question(this.current_question_number-1);
            /** select user Answer */
            /** color if flag */
            /** update Progress bar */
            this.updateProgress();
        },
        next: function(){
            /** Store Last Current Question Answer */
            if(!app.cx_quiz){
                this.storeToDB();
            }
            /** validation */
            if(app.current_question_number + 1 <= 0 ||
                app.current_question_number + 1 > app.question_number ||
                !app.questions.length){
                return;
            }
            /** push question */
            this.push_question(this.current_question_number+1);

            /** select user Answer */
            /** color if flag */
            /** update Progress bar */
            this.updateProgress();
        },
        updateProgress: function(add){
            percent = Math.round((app.answeredQuestionNumber())/app.question_number*100);
            $('.progress-bar').attr('aria-valuenow', percent);
            $('.progress-bar').attr('style', 'width: '+percent+'%');
            this._('progress_bar').innerHTML = percent.toString().substr(0,5)+' %';
        },
        push_question: function(CQN/* Current question Number # start from 1*/){
            this.seeAnswer = false;
            this.current_question_number    = CQN;
            this.current_question_title     = this.getCurrentTitle();
            this.current_question_title_ar  = this.getCurrentQuestion().question_title_ar;
            this.current_question_feedback  = this.getCurrentFeedback();
            this.current_question_image     = this.getCurrentQuestionImage();
            this.current_question_type_id   = this.getCurrentQuestion().question_type_id;
            this.current_question_flag      = this.user_answers[this.getCurrentQuestion().id].flag;
            this.current_question_correct_answers_required  = this.getCurrentQuestion().correct_answers_required;

            /** Toggle loading back */
            if(this.isFillInTheBlank || this.isMatchingToRight || this.isMatchingToCenter){
                setTimeout(() => this.toggleLoading(), 0);
            }

            if(this.isMultipleChoice || this.isFillInTheBlank || this.isMultipleResponses){
                this.current_question_choices   = this.getCurrentChoices();
                if(this.isFillInTheBlank){
                    /** init Tagify */
                    whiteList = this.getCurrentQuestion().answers.map(row => {
                        return {
                            answer_id: row.id,
                            value: app.language == 'ar'? row.transcodes.answer: row.answer,
                        };
                    });
                    /** i delay it for view rendering issue */
                    setTimeout(function(){
                        app.tagify = app.initTagify(whiteList, app.current_question_correct_answers_required);
                        app.tagify.on('add', app.applyUserFill)
                            .on('remove', app.applyUserFill);
                    }, 1)

                }
            }else if(this.isMatchingToRight || this.isMatchingToCenter){
                /** let the view render first */
                setTimeout(() => this.initMatch(), 100);
            }
            /** Destroy it on other questions & reset value */
            if(!app.isFillInTheBlank){
                if(app.tagify){
                    app.tagify.destroy();
                    app.tagify = null;
                }
            }

            /** Select User Stored Answers */
            this.selectUserStoredAnswer();
            /** switch control buttons */
            this.toggleControls();
            /** Toggle loading back */
            if(this.isFillInTheBlank || this.isMatchingToRight || this.isMatchingToCenter){
                setTimeout(() => this.toggleLoading(), 500);
            }

        },
        selectUserStoredAnswer: function(){
            if(this.isMultipleChoice){
                /** Multiple Choices */
                current = this.user_answers[this.getCurrentQuestion().id].answer;
                if(current){
                    this.multipleChoiceValue = current.answer_id;
                }
            }
            if(this.isMultipleResponses){
                /** Multiple Responses */
                /** sync the multipleResponseValue array */
                current = this.user_answers[this.getCurrentQuestion().id];
                if(current){
                    this.multipleResponseValue = current.answers;
                }
            }
            if(this.isFillInTheBlank){
                /** Fill In The Blank */
                user_answers = this.user_answers[this.getCurrentQuestion().id].answers.filter(function(row){
                    return row.selected;
                }).map(row => {
                    return {
                        answer_id: row.id,
                        value: app.language == 'ar'? row.transcodes.answer: row.answer,
                    };
                });
                /** Delay is due to rendering issue */
                setTimeout(function(){
                    app.tagify.addTags(user_answers);
                }, 500);
            }
        },
        applyUserCenterDrag: function(dragged_ele, target_location){
            this.changesFlag = true;
            dragged_ele_id = dragged_ele.getAttribute('data-id');
            target_location = target_location.getAttribute('data-position');

            dragged_ele_location = dragged_ele.getAttribute('data-position');
            if(target_location == 'center'){
                if(dragged_ele_location == 'left'){

                    app.user_answers[app.currentQuestionId]
                        .center[dragged_ele_id].left.selected = true;
                    app.user_answers[app.currentQuestionId]
                        .center[dragged_ele_id].right.selected = false;

                }else if(dragged_ele_location == 'right'){

                    app.user_answers[app.currentQuestionId]
                        .center[dragged_ele_id].right.selected = true;
                    app.user_answers[app.currentQuestionId]
                        .center[dragged_ele_id].left.selected = false;

                }
            }else{
                if(dragged_ele_location == 'left'){
                    app.user_answers[app.currentQuestionId]
                        .center[dragged_ele_id].left.selected = false;
                }

                if(dragged_ele_location == 'right'){
                    app.user_answers[app.currentQuestionId]
                        .center[dragged_ele_id].right.selected = false;
                }

            }

        },
        applyUserRightDrag: function(dragged_ele, target_location){
            this.changesFlag = true;
            dragged_ele_id = dragged_ele.getAttribute('data-left-id');
            /** fist find the left_id where ever it is and remove it */
            if(app.user_answers[app.currentQuestionId].left[dragged_ele_id]){
                app.user_answers[app.currentQuestionId].left[dragged_ele_id] = null;
            }
            for(i=0; i < app.user_answers[app.currentQuestionId].right.length; i++){
                if(app.user_answers[app.currentQuestionId].right[i]){
                    if(app.user_answers[app.currentQuestionId].right[i].left){
                        if(app.user_answers[app.currentQuestionId].right[i].left.id
                            == dragged_ele_id){
                            app.user_answers[app.currentQuestionId].right[i].left = null;
                        }
                    }
                }
            }

            /** Then Add it to it's new place */
            if(target_location.hasAttribute('data-right-id')){
                target_location_id = target_location.getAttribute('data-right-id');
                app.user_answers[app.currentQuestionId].right[target_location_id].left =
                    app.getCurrentQuestion().drag_right.filter(function(ele){
                        return ele.id == dragged_ele_id;
                    })[0];
            }else{
                app.user_answers[app.currentQuestionId].left[dragged_ele_id] =
                    app.getCurrentQuestion().drag_right.filter(function(ele){
                        return ele.id == dragged_ele_id;
                    })[0];
            }
        },
        /** Fill in the Blank */
        applyUserFill: function(ce /** custom event */){
            if(this.isFillInTheBlank){
                answer = this.user_answers[this.getCurrentQuestion().id]
                    .answers[ce.detail.data.answer_id];
                if(answer){
                    this.user_answers[this.getCurrentQuestion().id]
                        .answers[ce.detail.data.answer_id].selected = ce.type == 'add'? true:false;
                    this.changesFlag = true;
                }
            }
        },
        /** Multiple Choices & Multiple Responses */
        applyUserChoice: function(answer_id, question_id){
            if(this.isMultipleChoice){
                /** Multiple Choices */
                this.user_answers[question_id]
                    .answer = {
                    question_id : question_id,
                    answer_id   : answer_id,
                };
                this.changesFlag = true;
            }
            if(this.isMultipleResponses){
                /** Multiple Responses*/
                /** check for answers count */
                selectedAnswersCount = this.user_answers[question_id].answers.filter(function(row) {
                    return row.selected;
                }).length;

                if(selectedAnswersCount < this.getCurrentQuestion().correct_answers_required){
                    answer = this.user_answers[question_id].answers[answer_id];
                    if(answer){
                        this.user_answers[question_id].answers[answer_id].selected = !answer.selected;
                    }
                }else{
                    this.multipleResponseValue[answer_id].selected = false;
                }
                this.changesFlag = true;
                /** sync the multipleResponseValue array */
                /** multipleResponseValue will be sync-ed on fly*/
            }
            /** apply change to DB */
        },
        toggleFlag:function(){
            this.current_question_flag = !this.current_question_flag;
            this.user_answers[this.getCurrentQuestion().id].flag
                = this.current_question_flag;
            /** apply change to DB */
            this.changesFlag = true;
        },
        toggleControls: function(){
            /** Control btns */
            if(app.current_question_number == app.question_number && app.question_number > 1){
                $("#prev").show();
                $("#next").hide();
                $("#finish_btn").show();
            }else if(app.current_question_number == 1 && app.question_number > 1){
                $("#next").show();
                $("#prev").hide();
                $("#finish_btn").hide();
            }else if(app.current_question_number == app.question_number && app.question_number == 1){
                $("#prev").hide();
                $("#next").hide();
                $("#finish_btn").hide();
            }else {
                $("#next").show();
                $("#prev").show();
                $("#finish_btn").hide();
            }
            if(app.question_num <= 1){
                $("#next").hide();
            }
        },
        toggleLoading: function(){
            $("#quiz").toggle();$("#quizLoading").toggle();
        },
        toggleResult: function(){
            $("#quiz").toggle();
            $(".result").toggle();
        },
        toggleLanguage: function(){
            this.language = this.language == 'en' ? 'ar': 'en';
        },
        /** Current Question Attributes */
        getCurrentQuestion: function(){
            return this.questions[this.current_question_number-1];
        },
        getQuestionById: function(question_id){
            const question = this.question.filter(i => i.id == question_id);
            return question.length ? question[0]: null;
        },
        getCurrentQuestionImage: function(){
            if(this.getCurrentQuestion().img)
                return quizAttr.base_url + '/storage/questions/' + this.baseName(this.getCurrentQuestion().img);
            else
                return null;
        },
        baseName: function (str){
            var base = new String(str).substring(str.lastIndexOf('/') + 1);
            return base;
        },
        /** Title */
        getQuestionTitle: function(getLanguage = null, question_idx = null){
            let questionObj;
            if(question_idx){
                questionObj = this.questions[question_idx];
            }else{
                questionObj = this.getCurrentQuestion();
            }
            if(!questionObj)
                return '';
            const lang = getLanguage ? getLanguage: this.language;
            let title = '';
            switch (lang) {
                case 'en':
                    title = questionObj.question_title;
                    break;
                case 'ar':
                    title = questionObj.question_title_ar;
                    break;
                case 'fr':
                    title = questionObj.question_title_fr;
                    break;
            }
            return title ? title: questionObj.question_title;
        },
        getCurrentTitle: function(getLanguage = null, question_idx = null){
            return this.getQuestionTitle(getLanguage, null);
        },
        /** Feedback */
        getCurrentFeedback: function(getLanguage = null){
            if(!this.getCurrentQuestion())
                return '';
            const lang = getLanguage ? getLanguage: this.language;
            let feedback = '';
            switch (lang) {
                case 'en':
                    feedback = this.getCurrentQuestion().feedback;
                    break;
                case 'ar':
                    feedback = this.getCurrentQuestion().feedback_ar;
                    break;
                case 'fr':
                    feedback = this.getCurrentQuestion().feedback_fr;
                    break;
            }
            return feedback ? feedback: this.getCurrentQuestion().feedback;
        },
        /** Choices */
        getCurrentChoices: function(){
            return this.getCurrentQuestion().answers;
        },

        optimizeQuiz:async function(){
            // console.log('[+] Send Request : '+new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds());

            /** Loading... */
            $("#optimizeForm").hide();$("#quiz").hide();$("#quizLoading").show();

            /** Send Request */
            res = await this.sendQuizRequest();
            // console.log('[+] Request Recived : '+new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds());

            if(res == '500' || res == '404') {
                location.reload();
            }
            /** Optimizing */
            /** set start part */
            app.start_from_ = res.start;
            /** set Question number */
            app.question_number = res.questions.length;
            /** set current question number */
            app.current_question_number = 1;
            /** check for answers history */
            /** set questions array */
            app.questions = res.questions;
            /** set answered question number */
            app.question_answered = res.answers_number;
            /** set question titles list */
            for(i=0; i < app.questions.length; i++){
                title  = this.getQuestionTitle(null, i);
                title =   (i+1) + '. '+ title +'..';
                app.question_title_list.push({
                    id: i+1,
                    title,
                });
            }
            /** set answers array and where to start from */
            for(i=0; i < app.questions.length; i++) {

                answer = null;
                answers = [];
                flag = false;
                if(res.activeAnswers){
                    if(res.activeAnswers[app.questions[i].id]){
                        if(app.questions[i].question_type_id == 1){
                            answer = {
                                question_id: app.questions[i].id,
                                answer_id: res.activeAnswers[app.questions[i].id][0].question_answer_id,
                            };
                            flag = res.activeAnswers[app.questions[i].id][0].flaged
                        }
                    }
                }


                app.user_answers[app.questions[i].id] = {
                    question_id: app.questions[i].id,
                    question_number: i + 1,
                    question_type_id: app.questions[i].question_type_id,
                    correct_answers_required: app.questions[i].correct_answers_required,
                    chapter: app.questions[i].chapter,
                    process_group: app.questions[i].process_group,
                    /** All following values to be set from history */
                    flag,
                    answer, /** for multipleChoice */
                    answers,   /** for multipleResponses & fill in blank */
                    /** for Drag to right */
                    left: [],
                    right: [],
                    /** for Drag to center */
                    center: [],
                    user_answer_is_correct: false, /** by default */
                };
                /** Build the answers array for MultipleResponse & Fill in the Blank */
                if (app.questions[i].answers){
                    for (j = 0; j < app.questions[i].answers.length; j++) {
                        selected = false;
                        flag = false;
                        if(res.activeAnswers){
                            if(res.activeAnswers[app.questions[i].id]){
                                item = res.activeAnswers[app.questions[i].id].filter(row => {
                                    return row.question_answer_id == app.questions[i].answers[j].id;
                                });
                                if(item.length){
                                    flag = item[0].flaged ? true: false;
                                }
                                selected = item.length > 0;
                            }
                        }
                        this.user_answers[app.questions[i].id].flag = flag;
                        this.user_answers[app.questions[i].id].answers[
                            app.questions[i].answers[j].id
                            ] = {
                            answer_id: app.questions[i].answers[j].id,
                            is_correct: app.questions[i].answers[j].is_correct,
                            answer: app.questions[i].answers[j].answer,
                            transcodes: app.questions[i].answers[j].transcodes,
                            selected // must be supplied from history if exists
                        };


                    }
                }
                /** Build the [left] & [right] for Matching to Right */
                if(app.questions[i].drag_right){
                    taken_from_left = []; // of left item id
                    for(j=0; j < app.questions[i].drag_right.length; j++){
                        left = null;
                        flag = false;
                        if(res.activeDragRightAnswers){
                            if(res.activeDragRightAnswers[app.questions[i].id]){
                                left_item = res.activeDragRightAnswers[app.questions[i].id]
                                    .filter(row => {
                                        return app.questions[i].drag_right[j].id
                                            == row.question_drag_right_id;
                                    });
                                if(left_item.length){
                                    flag = left_item[0].flaged;
                                    left_id = left_item[0].question_drag_left_id;
                                    left = app.questions[i].drag_right.filter(row => {
                                        return row.id == left_id;
                                    });
                                    if(left.length){
                                        left = left[0];
                                        taken_from_left.push(left.id);
                                    }else{
                                        left = null;
                                    }

                                }

                            }

                        }
                        app.user_answers[app.questions[i].id].flag = flag;


                        // right side setup
                        app.user_answers[app.questions[i].id]
                            .right[app.questions[i].drag_right[j].id] = {
                            ...(app.questions[i].drag_right[j]),
                            left, // must be supplied from history if exists
                        };

                    }
                    for(j=0; j < app.questions[i].drag_right.length; j++) {
                        if(!taken_from_left.includes(app.questions[i].drag_right[j].id))
                            app.user_answers[app.questions[i].id].left[
                                app.questions[i].drag_right[j].id
                                ] = app.questions[i].drag_right[j];
                    }
                }
                /** Build the [Center] for Matching to Center */
                if(app.questions[i].drag_center){
                    for(j=0; j < app.questions[i].drag_center.length; j++){
                        userAnswer = null;
                        flag = false;
                        randFlag = app.randomTrueOrFalse();

                        drag_center_j = app.questions[i].drag_center[j];
                        if(res.activeDragCenterAnswers) {
                            history_ = res.activeDragCenterAnswers[app.questions[i].id];
                            if(history_){
                                if (history_.length) {
                                    history_item = history_.filter(row => {
                                        return row.question_drag_center_id == drag_center_j.id;
                                    });
                                    if (history_item.length) {
                                        history_item = history_item[0];
                                        userAnswer = history_item.user_answer;
                                    }
                                }
                            }
                        }

                        app.user_answers[app.questions[i].id]
                            .center[drag_center_j.id] = {
                            ...(drag_center_j),
                            left: {
                                selected: randFlag ? userAnswer == drag_center_j.correct_sentence: userAnswer == drag_center_j.wrong_sentence, // must be from history
                                left_sentence: randFlag ? drag_center_j.correct_sentence: drag_center_j.wrong_sentence,
                                transcodes: {
                                    left_sentence_ar: randFlag ? drag_center_j.transcodes.correct_sentence_ar: drag_center_j.transcodes.wrong_sentence_ar,
                                    left_sentence_fr: randFlag ? drag_center_j.transcodes.correct_sentence_fr: drag_center_j.transcodes.wrong_sentence_fr,
                                },
                            },
                            right: {
                                selected: randFlag ? userAnswer == drag_center_j.wrong_sentence: userAnswer == drag_center_j.correct_sentence, // must be from history
                                right_sentence: randFlag ? drag_center_j.wrong_sentence: drag_center_j.correct_sentence,
                                transcodes: {
                                    right_sentence_ar: randFlag ? drag_center_j.transcodes.wrong_sentence_ar: drag_center_j.transcodes.correct_sentence_ar,
                                    right_sentence_fr: randFlag ? drag_center_j.transcodes.wrong_sentence_fr: drag_center_j.transcodes.correct_sentence_fr,
                                },
                            },
                        };

                    }
                }
            }
            /** Start From last Question */
            /** Push Question */
            app.push_question(app.getLastQuestionAnsweredNumber());
            /** set the timer on */
            app.base_question_number = app.question_number - app.question_answered;

            const totalTimeSec = res.examTimeMin * 60; // minutes
            if(totalTimeSec && totalTimeSec > 0){
                timeByQuestion = totalTimeSec / app.base_question_number;
            }else{
                timeByQuestion = 76.7;
            }

            app.timer.start({countdown: true, startValues: {seconds: (app.base_question_number) * timeByQuestion } });
            app.timer.addEventListener('secondsUpdated', function (e) {
                $('#timer').html((app.timer.getTimeValues().hours * 60 + app.timer.getTimeValues().minutes) + ':'+app.timer.getTimeValues().seconds);
                app.time_taken = (app.base_question_number * timeByQuestion) - ((app.timer.getTimeValues().days * 24 * 3600 ) + (app.timer.getTimeValues().hours * 3600) + (app.timer.getTimeValues().minutes * 60) +(app.timer.getTimeValues().seconds));
            });
            /** update Progress */
            app.updateProgress();
            /** Show quiz */
            $("#quiz").show();
            $("#quizLoading").hide();

            // console.log(res);
            return;
        },
        randomTrueOrFalse: function(){
            return Math.random() > 0.5 ? true: false;
        },
        sendQuizRequest:async function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizAttr.api.csrf
                }
            });
            return $.ajax ({
                type: 'POST',
                url: quizAttr.api.generate_quiz,
                data: {
                    topic: this.topic_type,
                    topic_id: this.topic_id,
                    package: this.package_id,
                    quiz_id: quizAttr.saved_quiz_id,
                    part_id: quizAttr.api.part_id,
                },
                error: function(res){
                    console.log('Error:', res);
                }
            });
        },
        getLastQuestionAnsweredNumber: function(){
            last_question_answered_number = 1;
            for (const [question_id, user_answer] of Object.entries(app.user_answers)) {
                switch (user_answer.question_type_id) {
                    case 1:
                        /** Multiple Choice */
                        if(user_answer.answer){
                            last_question_answered_number = user_answer.question_number;
                        }
                        break;
                    case 2:
                    /** Multiple Response */
                    case 4:
                        /** Fill in the Blank */
                        answers_ = user_answer.answers.filter(row => {
                            return row.selected;
                        });
                        if(answers_.length){
                            last_question_answered_number = user_answer.question_number;
                        }
                        break;
                    case 3:
                        /** Matching Right */
                        answers = user_answer.right.filter(row => {
                            return row.left;
                        });
                        if(answers.length > 0){
                            last_question_answered_number = user_answer.question_number;
                        }
                        break;
                    case 5:
                        /** Matching To Center */
                        answers = user_answer.center.filter(row => {
                            return row.left.selected || row.right.selected;
                        });
                        if(answers.length > 0) {
                            last_question_answered_number = user_answer.question_number;
                        }
                        break;
                    default:
                        /** do nothing ^_^ */
                        break;
                }
            }
            return last_question_answered_number;
        },
        loadTopic: function(topic_key){

            exec_request = true;
            // if(topic_key == 'chapter'){
            //     if(app.chapters_inc.length > 0 ) exec_request = false;
            // }else if(topic_key == 'process'){
            //     if(app.process_inc.length > 0 ) exec_request = false;
            // }else if(topic_key == 'exam'){
            //     if(app.exams_inc.length > 0 ) exec_request = false;
            // }

            if(exec_request){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': quizAttr.api.csrf,
                    }
                });

                return $.ajax ({
                    type: 'POST',
                    url: quizAttr.api.load_topic,
                    data: {
                        'package_id'    : this.package_id,
                        'topic'         : topic_key,
                    },
                    success: function(res){
                        if(topic_key == 'chapter'){
                            app.chapters_inc = res;
                        }else if(topic_key == 'process'){
                            app.process_inc = res;
                        }else if(topic_key == 'exam'){
                            app.exams_inc = res;
                        }
                    },
                    error: function(err){console.log('error', err);}
                });

            }

        },
        topicURL: function(topic_key, topic_id, part_id = null){
            var url = quizAttr.base_url+'/PremiumQuiz/'+this.package_id+'/'+topic_key+'/'+topic_id+'/preview/realtime';
            if(part_id){
                url += '?part_id='+part_id;
            }
            return url;

        },
        isWatched: function(i_count){
            return i_count > 0 ? 'bg-primary':'bg-muted';
        },
        itemHighlighted: function(topic_type, topic_id){
            return (topic_type == this.topic_type && topic_id == this.topic_id)
            || (topic_type =='video' && topic_id == this.video_id)
            || (topic_type =='explanation' && topic_id == this.explanation_id) ? '': 'muted-link';
        },
        feedMeBack: function(){
            this.markUserAnswer(this.currentQuestionId);
            this.seeAnswer = true;
            setTimeout(() => this.seeAnswer = false, 5000);
            window.open(quizAttr.api.feedback+"/"+this.getCurrentQuestion().id,'_blank','resizable,height=350,width=500');
            return false;
        },
        answeredQuestionNumber: function(){
            counter = 0;
            for(const question of this.questions){
                if(question){
                    if(question.question_type_id == 2 ||
                        question.question_type_id == 4
                    ){
                        answerCount = this.user_answers[question.id].answers
                            .filter(function(row){
                                return row.selected;
                            }).length;
                        if(answerCount == question.correct_answers_required)
                            counter++;
                    }
                    if(question.question_type_id == 1){
                        if(this.user_answers[question.id].answer != null){
                            counter++;
                        }
                    }
                    if(question.question_type_id == 3){
                        unMatchedCount = this.user_answers[question.id]
                            .right.filter(function(row){
                                return !row.left;
                            }).length;
                        if(unMatchedCount == 0){
                            counter++;
                        }
                    }
                    if(question.question_type_id == 5){
                        unMatchedCount = this.user_answers[question.id].center.filter(row => {
                            return !row.right.selected && !row.left.selected;
                        }).length;
                        if(unMatchedCount == 0){
                            counter++;
                        }
                    }
                }


            }
            return counter;
        },
        openCalc: function(){
            window.open(quizAttr.calculator_url,'_blank','resizable,height=280,width=600');
        },
        openWhiteBoard: function(){
            window.open(quizAttr.whiteBoard_url,'_blank','resizable,height=700,width=750');
        },
        _: function (ele) {
            return document.getElementById(ele);
        },
        groupBy: function(objectArray, property) {
            return objectArray.reduce((acc, obj) => {
                const key = obj[property];
                if (!acc[key]) {
                    acc[key] = [];
                }
                // Add object to list for given key's value
                acc[key].push(obj);
                return acc;
            }, {});
        },
        showReview: function(){
            uri = quizAttr.api.quizHistoryShow + '/' + this.saved_quiz_id;
            window.location.href = uri;
        },
        slideMe: function(show, hide){
            $('#'+show).slideDown();
            $('#'+hide).slideUp();
        },

        post_review: function () {
            Data = {
                user_review: this.user_review,
                package_id: this.package_id
            };


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizAttr.api.csrf
                }
            });

            $.ajax({
                type: 'POST',
                url: quizAttr.api.postReview,
                data: Data,
                success: function (res) {
                },
                error: function (res) {
                    console.log('Error:', res);
                }


            });

        },
        rate_state: function (r_s) {
            this.rate_sentance = r_s;
        },
        rate: function () {
            Data = {
                rate: this.rate_value,
                package_id: this.package_id
            };


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizAttr.api.csrf,
                }
            });

            $.ajax({
                type: 'POST',
                url: quizAttr.api.userRate,
                data: Data,
                success: function (res) {
                    $("#rateTextBox").slideDown();
                },
                error: function (res) {
                    console.log('Error:', res);
                }


            });

        },
        ShowReplyForm: function (comment_id) {
            if (this._('reply-form-' + comment_id).innerHTML == '') {
                this._('reply-form-' + comment_id).innerHTML = '<div class="row"><div class="col-md-10 col-md-offset-2"><form action="{{route("comment.reply")}}" method="post">@csrf<input type="hidden" name="reply_to_id" value="'+comment_id+'"><div class="form-group col-md-8" style="padding-left: 0 !important;"><textarea rows="1" name="contant" placeholder="Write comment here ..." class="form-control c-square" required></textarea></div><div class="form-group col-md-4"><div class="row"><button type="submit" class="btn blue uppercase btn-md col-md-6 sbold">Reply</button></div></div></form></div></div>';
            } else {
                this._('reply-form-' + comment_id).innerHTML = '';
            }
        },
        removeReplyForm: function (comment_id) {
            this._('reply-form-' + comment_id).innerHTML = '';
        },
        toggle_right_list: function(){
            $(".right_list").slideToggle();
            if(this.toggle_list == 0){
                $("#arrow").addClass('fa-arrow-left');
                $("#arrow").removeClass('fa-arrow-right');
                $("#quiz_app_container").addClass('col-md-12');
                $("#quiz_app_container").removeClass('col-md-8');
                this.toggle_list = 1;
            }else{
                $("#quiz_app_container").removeClass('col-md-12');
                $("#quiz_app_container").addClass('col-md-8');
                $("#arrow").removeClass('fa-arrow-left');
                $("#arrow").addClass('fa-arrow-right');

                this.toggle_list = 0;
            }
        },

        continueQuize: function(){
            this.timer.start();
            $("#quiz").show();
            $('#optimizeForm').hide();
            $('#startQuiz').show();
            $('#continueQuiz').hide();
        },
        stopTimer_pause: function(){
            this.timer.pause();
            this.storeToDB();
            $("#quiz").hide();
            $('#optimizeForm').show();
            $('#startQuiz').hide();
            $('#continueQuiz').show();
        },
        sendCXQuizRequest: async function(topic, items_arr){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizAttr.api.csrf,
                }
            });
            return $.ajax ({
                type: 'POST',
                url: quizAttr.api.cxQuiz,
                data: {
                    topic,
                    items_arr,
                    package: app.package_id,
                },
                error: function(err){
                    console.log('Error: ', err);
                },
            });
        },
        Generate_CX:async function(){
            $("#ExamGenerator").hide();
            // console.log('[+] Send Request : '+new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds());

            /** Loading... */
            $("#optimizeForm").hide();$("#quiz").hide();$("#quizLoading").show();

            const topic = this.cx_topic;
            const items_arr = this.cx_checkedItems.map(function(ele) { return parseInt(ele);}); // convert items from string to intager..

            /** Send Request */
            res = await this.sendCXQuizRequest(topic, items_arr);
            // console.log('[+] Request Recived : '+new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds());

            if(res == '500' || res == '404') {
                location.reload();
            }
            app.cx_quiz = true;
            /** Optimizing */
            /** set start part */
            app.start_from_ = res.start;
            /** set Question number */
            app.question_number = res.questions.length;
            /** set current question number */
            app.current_question_number = 1;
            /** check for answers history */
            /** set questions array */
            app.questions = res.questions;
            /** set answered question number */
            app.question_answered = res.answers_number;
            /** set question titles list */
            for(i=0; i < app.questions.length; i++){
                title = app.language == 'en' ? app.questions[i].question_title
                    :app.questions[i].question_title_ar;
                title =   (i+1) + '. '+ title +'..';
                app.question_title_list.push({
                    id: i+1,
                    title,
                });
            }
            /** set answers array and where to start from */
            for(i=0; i < app.questions.length; i++) {

                answer = null;
                answers = [];
                flag = false;
                if(res.activeAnswers){
                    if(res.activeAnswers[app.questions[i].id]){
                        if(app.questions[i].question_type_id == 1){
                            answer = {
                                question_id: app.questions[i].id,
                                answer_id: res.activeAnswers[app.questions[i].id][0].question_answer_id,
                            };
                            flag = res.activeAnswers[app.questions[i].id][0].flaged
                        }
                    }
                }


                app.user_answers[app.questions[i].id] = {
                    question_id: app.questions[i].id,
                    question_number: i + 1,
                    question_type_id: app.questions[i].question_type_id,
                    correct_answers_required: app.questions[i].correct_answers_required,
                    chapter: app.questions[i].chapter,
                    process_group: app.questions[i].process_group,
                    /** All following values to be set from history */
                    flag,
                    answer, /** for multipleChoice */
                    answers,   /** for multipleResponses & fill in blank */
                    /** for Drag to right */
                    left: [],
                    right: [],
                    /** for Drag to center */
                    center: [],
                    user_answer_is_correct: false, /** by default */
                };

                /** Build the answers array for MultipleResponse & Fill in the Blank */
                if (app.questions[i].answers){
                    for (j = 0; j < app.questions[i].answers.length; j++) {
                        selected = false;
                        flag = false;
                        this.user_answers[app.questions[i].id].flag = flag;
                        this.user_answers[app.questions[i].id].answers[
                            app.questions[i].answers[j].id
                            ] = {
                            answer_id: app.questions[i].answers[j].id,
                            is_correct: app.questions[i].answers[j].is_correct,
                            answer: app.questions[i].answers[j].answer,
                            transcodes: app.questions[i].answers[j].transcodes,
                            selected // must be supplied from history if exists
                        };


                    }
                }
                /** Build the [left] & [right] for Matching to Right */
                if(app.questions[i].drag_right){
                    taken_from_left = []; // of left item id
                    for(j=0; j < app.questions[i].drag_right.length; j++){
                        left = null;
                        flag = false;
                        app.user_answers[app.questions[i].id].flag = flag;


                        // right side setup
                        app.user_answers[app.questions[i].id]
                            .right[app.questions[i].drag_right[j].id] = {
                            ...(app.questions[i].drag_right[j]),
                            left, // must be supplied from history if exists
                        };

                    }
                    for(j=0; j < app.questions[i].drag_right.length; j++) {
                        if(!taken_from_left.includes(app.questions[i].drag_right[j].id))
                            app.user_answers[app.questions[i].id].left[
                                app.questions[i].drag_right[j].id
                                ] = app.questions[i].drag_right[j];
                    }
                }
                /** Build the [Center] for Matching to Center */
                if(app.questions[i].drag_center){
                    for(j=0; j < app.questions[i].drag_center.length; j++){
                        userAnswer = null;
                        flag = false;
                        randFlag = app.randomTrueOrFalse();

                        drag_center_j = app.questions[i].drag_center[j];


                        app.user_answers[app.questions[i].id]
                            .center[drag_center_j.id] = {
                            ...(drag_center_j),
                            left: {
                                selected: randFlag ? userAnswer == drag_center_j.correct_sentence: userAnswer == drag_center_j.wrong_sentence, // must be from history
                                left_sentence: randFlag ? drag_center_j.correct_sentence: drag_center_j.wrong_sentence,
                                transcodes: {
                                    left_sentence: randFlag ? drag_center_j.transcodes.correct_sentence: drag_center_j.transcodes.wrong_sentence,
                                },
                            },
                            right: {
                                selected: randFlag ? userAnswer == drag_center_j.wrong_sentence: userAnswer == drag_center_j.correct_sentence, // must be from history
                                right_sentence: randFlag ? drag_center_j.wrong_sentence: drag_center_j.correct_sentence,
                                transcodes: {
                                    right_sentence: randFlag ? drag_center_j.transcodes.wrong_sentence: drag_center_j.transcodes.correct_sentence,
                                },
                            },
                        };

                    }
                }
            }
            /** Start From last Question */
            /** Push Question */
            app.push_question(1);
            /** set the timer on */
            app.base_question_number = app.question_number - app.question_answered;
            app.timer.start({countdown: true, startValues: {seconds: (app.base_question_number) * 76.7 } });
            app.timer.addEventListener('secondsUpdated', function (e) {
                $('#timer').html((app.timer.getTimeValues().hours * 60 + app.timer.getTimeValues().minutes) + ':'+app.timer.getTimeValues().seconds);
                app.time_taken = (app.base_question_number * 76.7) - ((app.timer.getTimeValues().days * 24 * 3600 ) + (app.timer.getTimeValues().hours * 3600) + (app.timer.getTimeValues().minutes * 60) +(app.timer.getTimeValues().seconds));
            });
            /** update Progress */
            app.updateProgress();
            /** Show quiz */
            $("#quiz").show();
            $("#quizLoading").hide();

            // console.log(res);
            return;
        },
        clearCheckedItems: function(){
            this.cx_checkedItems = [];
        },


    }
});
