var app = new Vue({
    el: '#app-1',
    data: {
        answers_filter: '3',

        question_number: 0,
        question_answered: 0,
        current_question_number: 1,
        questions: [],
        allQuestions: [],
        user_answers: [],

        overallScore: 0,
        ScoreMsg: '',

        current_question_status: '',
        current_question_title: '',
        current_question_feedback: '',
        current_question_choices: [],
        current_question_image: null,
        current_question_flag: false,
        current_question_type_id: 0,
        current_question_correct_answers_required: 1,

        /** current Question answers holders */
        multipleChoiceValue: '',
        multipleResponseValue: [],
        FillInTheBlankValue: [],

        /** Language : set as Default for current page*/
        language: quizHistoryAttr.language,
        alpha: ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"],

    },
    mounted() {
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
        this.optimizeHistory();
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
        currentSelectedAnswersCount: function(){
            if(this.isFillInTheBlank || this.isMultipleResponses){
                return this.user_answers[this.getCurrentQuestion().id]
                    .answers.filter(function(row){
                        return row.selected;
                    }).length;
            }
            return 0;
        },
    },
    methods: {
        updateCircle: function(label){
            console.log(label);
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
        prev: function(){
            /** validation */
            if((app.current_question_number - 1) <= 0 ||
                app.current_question_number - 1 > app.questions.length ||
                !app.questions.length){
                return;
            }
            /** push question */
            this.push_question(this.current_question_number-1);
        },
        next: function(){
            /** validation */
            if(app.current_question_number + 1 <= 0 ||
                app.current_question_number + 1 > app.questions.length ||
                !app.questions.length){
                return;
            }
            /** push question */
            this.push_question(this.current_question_number+1);
        },
        toggleFilter: function(){
            switch(this.answers_filter){
                case '3':
                    /** all */
                    this.current_question_number = 1;
                    this.questions = this.allQuestions;
                    this.push_question(this.current_question_number);
                    break;
                case '0':
                    /** incorrect */
                    filteredAnswers = this.allQuestions.filter(row => {
                        return !app.user_answers[row.id].user_answer_is_correct
                            && !app.user_answers[row.id].skipped;
                    });
                    if(filteredAnswers.length){
                        this.current_question_number = 1;
                        this.questions = filteredAnswers;
                        this.push_question(this.current_question_number);
                    }
                    break;
                case '1':
                    /** correct */
                    filteredAnswers = this.allQuestions.filter(row => {
                        return app.user_answers[row.id].user_answer_is_correct;
                    });
                    if(filteredAnswers.length){
                        this.current_question_number = 1;
                        this.questions = filteredAnswers;
                        this.push_question(this.current_question_number);
                    }
                    break;
                case '2':
                    /** skipped */
                    filteredAnswers = this.allQuestions.filter(row => {
                        return app.user_answers[row.id].skipped;
                    });
                    if(filteredAnswers.length){
                        this.current_question_number = 1;
                        this.questions = filteredAnswers;
                        this.push_question(this.current_question_number);
                    }
                    break;
                case '4':
                    /** flag */
                    filteredAnswers = this.allQuestions.filter(row => {
                        return app.user_answers[row.id].flag;
                    });
                    if(filteredAnswers.length){
                        this.current_question_number = 1;
                        this.questions = filteredAnswers;
                        this.push_question(this.current_question_number);
                    }
                    break;
            }
        },
        markExam: function(){
            /** Mark User Answers */
            for (const [question_id, user_answer] of Object.entries(app.user_answers)) {
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
            }
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
                this.ScoreMsg = '<h4 style="font-weight:bold">:'+quizHistoryAttr.translation.overallPerformance+'<b style="color:springgreen;">'+quizHistoryAttr.translation.passed+'</b></h4>You have passed the exam, congratulations.';
            }else{
                this.ScoreMsg = '<h4 style="font-weight:bold">'+quizHistoryAttr.translation.overallPerformance+': <b style="color:#DC143C;">'+quizHistoryAttr.translation.failed+'</b></h4>You have failed your exam, you must improve to get certified.';
            }
            /** Result by process */
            // for (const [process_group, user_answers_] of Object.entries(userAnswersByProcess)) {
            //     process_score = user_answers_.filter(row => row.user_answer_is_correct).length / user_answers_.length * 100;
            //     if(process_score <= 65){
            //         msg = '<i style="color: red;">'+quizHistoryAttr.translation.needImprove+'</i>';
            //     }else if(process_score > 65 && process_score < 75){
            //         msg = '<i style="color: red;">'+quizHistoryAttr.translation.belowTarget+'</i>';
            //     }else if(process_score >= 75 && process_score < 85){
            //         msg = '<i style="color: #999900;">'+quizHistoryAttr.translation.target+'</i>';
            //     }else if(process_score >= 85){
            //         msg = '<i style="color:green;">'+quizHistoryAttr.translation.aboveTarget+'</i>';
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
        },
        questionResult: function(question_id, value){
            app.user_answers[question_id].user_answer_is_correct = value;
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
        push_question: function(CQN/* Current question Number # start from 1*/){
            this.current_question_number    = CQN;
            this.current_question_title     = this.getCurrentTitle();
            this.current_question_feedback  = this.getCurrentFeedback();
            this.current_question_image     = this.getCurrentQuestionImage();
            this.current_question_type_id   = this.getCurrentQuestion().question_type_id;
            this.current_question_flag      = this.user_answers[this.getCurrentQuestion().id].flag;
            this.current_question_correct_answers_required  = this.getCurrentQuestion().correct_answers_required;
            this.current_question_status    = this.user_answers[this.currentQuestionId].user_answer_is_correct ?
                    'correct': this.user_answers[this.currentQuestionId].skipped ?
                        'skipped': 'wrong';

            if(this.isMultipleChoice || this.isFillInTheBlank || this.isMultipleResponses){
                this.current_question_choices   = this.getCurrentChoices();
            }else if(this.isMatchingToRight || this.isMatchingToCenter){

            }
            /** Select User Stored Answers */
            this.selectUserStoredAnswer();

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
                /** Multiple Responses */
                /** sync the multipleResponseValue array */
                current = this.user_answers[this.getCurrentQuestion().id];
                if(current){
                    this.fillInTheBlankValue = current.answers;
                }
            }
        },
        optimizeHistory: async function(){
            // console.log('[+] Send Request : '+new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds());
            res = await this.getQuizHistoryRequest();
            // console.log(res);
            // console.log('[+] Request Recived : '+new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds());

            /** Optimizing */
            /** set Question number */
            app.question_number = res.questions.length;
            /** set current question number */
            app.current_question_number = 1;
            /** check for answers history */
            /** set questions array */
            app.allQuestions = res.questions;
            /** question would be filtered inside this array */
            app.questions = res.questions;
            /** set answered question number */
            app.question_answered = res.answers_number;
            /** set answers array and where to start from */
            for(i=0; i < app.questions.length; i++) {

                answer = null;
                answers = [];
                flag = false;
                skipped = true;
                if(res.answers){
                    if(res.answers[app.questions[i].id]){
                        if(app.questions[i].question_type_id == 1){
                            answer = {
                                question_id: app.questions[i].id,
                                answer_id: res.answers[app.questions[i].id][0].question_answer_id,
                            };
                            flag = res.answers[app.questions[i].id][0].flaged
                            skipped = false;
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
                    skipped,
                };
                /** Build the answers array for MultipleResponse & Fill in the Blank */
                if (app.questions[i].answers){
                    for (j = 0; j < app.questions[i].answers.length; j++) {
                        selected = false;
                        flag = false;
                        if(res.answers){
                            if(res.answers[app.questions[i].id]){
                                this.user_answers[app.questions[i].id].skipped = false;
                                item = res.answers[app.questions[i].id].filter(row => {
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
                        if(res.dragRightAnswers){
                            if(res.dragRightAnswers[app.questions[i].id]){
                                left_item = res.dragRightAnswers[app.questions[i].id]
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
                                        app.user_answers[app.questions[i].id].skipped = false;
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
                        if(res.dragCenterAnswers) {
                            history_ = res.dragCenterAnswers[app.questions[i].id];
                            if(history_){
                                if (history_.length) {
                                    history_item = history_.filter(row => {
                                        return row.question_drag_center_id == drag_center_j.id;
                                    });
                                    if (history_item.length) {
                                        history_item = history_item[0];
                                        userAnswer = history_item.user_answer;
                                        app.user_answers[app.questions[i].id].skipped = false;
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

            /** mark exam */
            this.markExam();
            /** Push First Question */
            app.push_question(app.current_question_number);

            this.toggleLoading();
        },
        randomTrueOrFalse: function(){
            return Math.random() > 0.5 ? true: false;
        },
        getQuizHistoryRequest: async function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': quizHistoryAttr.api.csrf,
                }
            });

            return $.ajax ({
                type: 'POST',
                url: quizHistoryAttr.api.quizHistory,
                data: {
                    quiz_id: quizHistoryAttr.quiz_id,
                },
                error: function(res){
                    console.log('Error:', res);
                }
            });
        },
        toggleLoading: function(){
            $("#loading1").toggle();
            $("#quiz").toggle();
            $(".result").toggle();
        },
        /** Current Question Attributes */
        getCurrentQuestion: function(){
            return this.questions[this.current_question_number-1];
        },
        getCurrentQuestionImage: function(){
            if(this.getCurrentQuestion().img)
                return quizHistoryAttr.base_url + '/storage/questions/' + this.baseName(this.getCurrentQuestion().img);
            else
                return null;
        },
        /** Title */
        getCurrentTitle: function(getLanguage = null){
            if(!this.getCurrentQuestion())
                return '';
            const lang = getLanguage ? getLanguage: this.language;
            let title = '';
            switch (lang) {
                case 'en':
                    title = this.getCurrentQuestion().question_title;
                    break;
                case 'ar':
                    title = this.getCurrentQuestion().question_title_ar;
                    break;
                case 'fr':
                    title = this.getCurrentQuestion().question_title_fr;
                    break;
            }
            return title ? title: this.getCurrentQuestion().question_title;
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
        baseName: function (str){
           var base = new String(str).substring(str.lastIndexOf('/') + 1); 
            return base;
        },
    }
});
