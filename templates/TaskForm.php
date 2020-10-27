<style type="text/css">
    <?php include 'public/plugins_packages/integral-learning/MumieTaskPlugin/mumieStyle.css';
    ?>

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<form class="default" action="<?= $action; ?>" method="post">
    <fieldset class="conf-form-field collapsable">
        <legend>Allgemein</legend>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_name">
                <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'Name'); ?>
                </span>
            </label>
            <input id="mumie_name" required type="text" name="name" value="<?= $name?>">
        </div>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_server">
                <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'MUMIE-Server'); ?>
                </span>
            </label>
            <select id="mumie_server" name="server">
                <?php
                    $options = $collector->getServerOptions();
                    foreach (array_keys($options) as $key):
                ?>
                <option value=<?= $key; ?> <?= $key == $server ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>
                <?php endforeach ?>
            </select>
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Bitte wählen Sie einen MUMIE-Server, um eine aktuelle Auswahl von verfügbaren Kursen und Aufgaben zu erhalten.")
                    ]
                )->asImg();
            ?>
        </div>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_course">
                <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'MUMIE-Kurs'); ?>
                </span>
            </label>
            <select id="mumie_course" name="course">
                <?php
                        $options = $collector->getCourseOptions();
                        foreach (array_keys($options) as $key):
                    ?>
                <option value=<?= $key; ?> <?= $key == $mumie_course ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>

                <?php endforeach ?>
            </select>
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Bitte wählen Sie den MUMIE-Kurs, den Sie für diese MUMIE-Task verwenden möchten.")
                    ]
                )->asImg();
            ?>
        </div>
        <input type="hidden" id="mumie_coursefile" name="coursefile" value=<?= $mumie_coursefile;?>>
        <input type="hidden" id="mumie_missing_config" name="mumie_missing_config" value=<?= $missingServerConfig ? $server : ""?>>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_language">
                <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'Sprache'); ?>
                </span>
            </label>
            <select id="mumie_language" name="language">
                <?php
                        $options = $collector->getLangOptions();
                        foreach (array_keys($options) as $key):
                    ?>
                <option value=<?= $key; ?> <?= $key == $language ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>

                <?php endforeach ?>
            </select>
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Bitte wählen Sie die Sprache, in der diese MUMIE-Task angezeigt werden soll.")
                    ]
                )->asImg();
            ?>
        </div>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_taskurl">
                <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'MUMIE-Aufgabe'); ?>
                </span>
            </label>
            <select id="mumie_taskurl" name="task_url">
                <?php
                        $options = $collector->getTaskOptions();
                        foreach (array_keys($options) as $key):
                    ?>
                <option value=<?= $key; ?> <?= $key == $task_url ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>
                <?php endforeach ?>
            </select>
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Eine MUMIE-Aufgabe kann durch Studierende bearbeitet werden und wird einzeln benotet.")
                    ]
                )->asImg();
            ?>
        </div>
        <a id="mumie_prb_selector_btn" class="button"><?= dgettext("MumieTaskPlugin", "Abbrechen");?></a>
        <div class="mumie_form_elem_wrapper">

            <label for="mumie_launch_container">
                <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'Startcontainer'); ?>
                </span>
            </label>
            <select id="mumie_launch_container" name="launch_container">
                <option value="1" <?= $launch_container == 1 ? "selected = 'selected'" :"";?>>Eingebunden</option>
                <option value="0" <?= $launch_container == 0 ? "selected = 'selected'" :"";?>>Neuer Browser-Tab</option>
            </select>
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Bitte wählen Sie, ob diese Aktivität in die StudIP-Umgebung eingebunden oder in einem neuen Browser-Tab geöffnet werden soll.")
                        ]
                )->asImg();
            ?>
        </div>
    </fieldset>

    <fieldset class="conf-form-field collapsable collapsed">
        <legend><?= dgettext('MumieTaskPlugin', 'Benotung'); ?></legend>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_passing_grade">
                <?= dgettext('MumieTaskPlugin', 'Bestehensgrenze'); ?>
            </label>
            <input type="number" name="passing_grade" id="mumie_passing_grade" min="0" max="100"
                value="<?= $passing_grade ?? 60;?>">
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Geben Sie eine zum Bestehen der Aufgabe nötige Mindestpunktzahl an.")
                    ]
                )->asImg();
            ?>
        </div>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_due_date">
                <?= dgettext('MumieTaskPlugin', 'Abgabefrist'); ?>
            </label>
            <input type="text" name="duedate" id="mumie_due_date" data-datetime-picker
                value="<?= $duedate == 0 ? null : date('d.m.Y H:i', $duedate);?>">
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Falls diese Option aktiviert ist, werden keine Noten, die nach dem gewählten Datum erzielt wurden, mit StudIP synchronisiert.")
                    ]
                )->asImg();
            ?>
        </div>
    </fieldset>
    <a href="<?= $cancelLink; ?>" class="button"><?= dgettext("MumieTaskPlugin", "Abbrechen");?></a>
    <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
</form>

<script>
    (function() {
        var missingConfig = document.getElementsByName("mumie_missing_config")[0];
        var lmsSelectorUrl = 'http://localhost:7070';

        var serverController = (function() {
            var serverStructure;
            var serverDropDown = document.getElementById("mumie_server");

            return {
                init: function(structure) {
                    serverStructure = structure;
                    serverDropDown.onchange = function() {
                        courseController.updateOptions();
                        langController.updateOptions();
                        taskController.updateOptions();
                    };
                },
                getSelectedServer: function() {
                    var selectedServerName = serverDropDown.options[serverDropDown.selectedIndex].text;

                    for (var i in serverStructure) {
                        var server = serverStructure[i];
                        if (server.name == selectedServerName) {
                            return server;
                        }
                    }
                    return null;
                },
                disable: function() {
                    serverDropDown.disabled = true;
                    removeChildElems(serverDropDown);
                }
            };
        })();

        var courseController = (function() {
            var courseDropDown = document.getElementById("mumie_course");
            var coursefileElem = document.getElementById("mumie_coursefile");

            /**
             * Add a new option the the 'MUMIE Course' drop down menu
             * @param {Object} course
             */
            function addOptionForCourse(course) {
                var optionCourse = document.createElement("option");
                for (var i in course.name) {
                    var name = course.name[i];
                    if (name.language == langController.getSelectedLanguage()) {
                        optionCourse.setAttribute("value", name.value);
                        optionCourse.text = name.value;
                        courseDropDown.append(optionCourse);
                    }
                }
            }

            /**
             * Update the hidden input field with the selected course's course file path
             */
            function updateCoursefilePath() {
                coursefileElem.value = courseController.getSelectedCourse().coursefile;
            }

            return {
                init: function(isEdit) {
                    courseDropDown.onchange = function() {
                        updateCoursefilePath();
                        langController.updateOptions();
                        taskController.updateOptions();
                    };
                    courseController.updateOptions(isEdit ? coursefileElem.value : false);
                },
                getSelectedCourse: function() {
                    var selectedCourseName = courseDropDown.options[courseDropDown.selectedIndex].text;
                    var courses = serverController.getSelectedServer().courses;
                    for (var i in courses) {
                        var course = courses[i];
                        for (var j in course.name) {
                            if (course.name[j].value == selectedCourseName) {
                                return course;
                            }
                        }
                    }
                    return null;
                },
                disable: function() {
                    courseDropDown.disabled = true;
                    removeChildElems(courseDropDown);
                },
                updateOptions: function(selectedCourseFile) {
                    removeChildElems(courseDropDown);
                    courseDropDown.selectedIndex = 0;
                    var courses = serverController.getSelectedServer().courses;
                    for (var i in courses) {
                        var course = courses[i];
                        addOptionForCourse(course);
                        if (course.coursefile == selectedCourseFile) {
                            courseDropDown.selectedIndex = courseDropDown.childElementCount - 1;
                        }
                    }
                    updateCoursefilePath();
                }
            };
        })();

        var langController = (function() {
            var languageDropDown = document.getElementById("mumie_language");

            /**
             * Add a new option to the language drop down menu
             * @param {string} lang the language to add
             */
            function addLanguageOption(lang) {
                var optionLang = document.createElement("option");
                optionLang.setAttribute("value", lang);
                optionLang.text = lang;
                languageDropDown.append(optionLang);
            }
            return {
                init: function() {

                    languageDropDown.onchange = function() {
                        taskController.updateOptions();
                        courseController.updateOptions();
                    };
                    langController.updateOptions();
                },
                getSelectedLanguage: function() {
                    return languageDropDown.options[languageDropDown.selectedIndex].text;
                },
                disable: function() {
                    languageDropDown.disabled = true;
                    removeChildElems(languageDropDown);
                },
                updateOptions: function() {
                    var currentLang = langController.getSelectedLanguage();
                    removeChildElems(languageDropDown);
                    languageDropDown.selectedIndex = 0;
                    var languages = courseController.getSelectedCourse().languages;
                    for (var i in languages) {
                        var lang = languages[i];
                        addLanguageOption(lang);
                        if (lang == currentLang) {
                            languageDropDown.selectedIndex = languageDropDown.childElementCount - 1;
                        }
                    }
                },
                setLanguage: function(lang) {
                    for (var i in languageDropDown.options) {
                        var option = languageDropDown.options[i];
                        if (option.value == lang) {
                            languageDropDown.selectedIndex = i;
                            courseController.updateOptions();
                            return;
                        }
                    }
                    throw new Error("Selected language not available");
                }
            };
        })();

        var taskController = (function() {
            var taskDropDown = document.getElementById("mumie_taskurl");
            var nameElem = document.getElementById("mumie_name");

            /**
             * Update the activity's name in the input field
             */
            function updateName() {
                nameElem.value = getHeadline(taskController.getSelectedTask());
            }

            /**
             * Get the task's headline for the currently selected language
             * @param {Object} task
             * @returns  {string} the headline
             */
            function getHeadline(task) {
                if (!task) {
                    return null;
                }
                for (var i in task.headline) {
                    var localHeadline = task.headline[i];
                    if (localHeadline.language == langController.getSelectedLanguage()) {
                        return localHeadline.name;
                    }
                }
                return null;
            }

            /**
             * Add lanugage parameter to the task's link to display content in the selected language
             * @param {Object} task
             * @returns {string}
             */
            function getLocalizedLink(task) {
                return task.link + "?lang=" + langController.getSelectedLanguage();
            }

            /**
             * Add a new option to the 'Problem' drop down menu
             * @param {Object} task
             */
            function addTaskOption(task) {
                if (getHeadline(task) !== null) {
                    var optionTask = document.createElement("option");
                    optionTask.setAttribute("value", getLocalizedLink(task));
                    optionTask.text = getHeadline(task);
                    taskDropDown.append(optionTask);
                }
            }

            return {
                init: function(isEdit) {
                    updateName();
                    taskDropDown.onchange = function() {
                        updateName();
                    };
                    taskController.updateOptions(isEdit ?
                        taskDropDown.options[taskDropDown.selectedIndex].getAttribute('value') +
                        "?lang=" + langController.getSelectedLanguage() : undefined
                    );
                },
                getSelectedTask: function() {
                    var selectedLink = taskDropDown.options[taskDropDown.selectedIndex] ==
                        undefined ? undefined : taskDropDown.options[taskDropDown.selectedIndex]
                        .getAttribute('value');
                    var tasks = courseController.getSelectedCourse().tasks;
                    for (var i in tasks) {
                        var task = tasks[i];
                        if (selectedLink == getLocalizedLink(task)) {
                            return task;
                        }
                    }
                    return null;
                },
                disable: function() {
                    taskDropDown.disabled = true;
                    removeChildElems(taskDropDown);
                },
                updateOptions: function(selectTaskByLink) {
                    removeChildElems(taskDropDown);
                    taskDropDown.selectedIndex = 0;
                    var tasks = courseController.getSelectedCourse().tasks;
                    for (var i in tasks) {
                        var task = tasks[i];
                        addTaskOption(task);
                        if (selectTaskByLink === getLocalizedLink(task)) {
                            taskDropDown.selectedIndex = taskDropDown.childElementCount - 1;
                        }
                    }
                    updateName();
                },
            };
        })();

        var problemSelectorController = (function() {
            var problemSelectorButton = document.getElementById('mumie_prb_selector_btn');
            var problemSelectorWindow;
            var mumieOrg = `<?= Config::get()->MUMIE_ORG;?>`

            /**
             * Send a message to the problem selector window.
             *
             * Don't do anything, if there is no problem selector window.
             * @param {Object} response
             */
            function sendResponse(response) {
                if (!problemSelectorWindow) {
                    return;
                }
                problemSelectorWindow.postMessage(JSON.stringify(response), lmsSelectorUrl);
            }

            /**
             * Send a success message to problem selector window
             * @param {string} message
             */
            function sendSuccess(message = '') {
                sendResponse({
                    success: true,
                    message: message
                });
            }

            /**
             * Send a failure message to problem selector window
             * @param {string} message
             */
            function sendFailure(message = '') {
                sendResponse({
                    success: false,
                    message: message
                });
            }

            /**
             * Add an event listener that accepts messages from LMS-Browser and updates the selected problem.
             */
            function addMessageListener() {
                window.addEventListener('message', (event) => {
                    if (event.origin != lmsSelectorUrl) {
                        return;
                    }
                    var importObj = JSON.parse(event.data);
                    try {
                        langController.setLanguage(importObj.language);
                        taskController.updateOptions(importObj.link + '?lang=' + importObj.language);
                        sendSuccess();
                        window.focus();
                        displayProblemSelectedMessage();
                    } catch (error) {
                        sendFailure(error.message);
                    }
                  }, false);
            }

            /**
             * Display a success message in Moodle that a problem was successfully selected.
             */
            function displayProblemSelectedMessage() {
                require(['core/str', "core/notification"], function(str, notification) {
                    str.get_strings([{
                        'key': 'mumie_form_updated_selection',
                        component: 'mod_mumie'
                    }]).done(function(s) {
                        notification.addNotification({
                            message: s[0],
                            type: "info"
                        });
                    }).fail(notification.exception);
                });
            }

            return {
                init: function() {
                    problemSelectorButton.onclick = function() {
                        problemSelectorWindow = window.open(
                            lmsSelectorUrl
                                + '/lms-problem-selector?'
                                + 'org='
                                + mumieOrg
                                + '&serverUrl='
                                + encodeURIComponent(serverController.getSelectedServer().url_prefix)
                                + "&lang="
                                + langController.getSelectedLanguage()
                                + "&problem=" + taskController.getSelectedTask().link
                                + "&origin=" + encodeURIComponent(window.location.origin)
                            , '_blank'
                        );
                    };

                    window.onclose = function() {
                        sendSuccess();
                    };

                    window.addEventListener("beforeunload", function() {
                        sendSuccess();
                     }, false);

                    addMessageListener();
                },
                disable: function() {
                    problemSelectorButton.disabled = true;
                }
            };
        })();

        /**
         * Remove all child elements of a given html element
         * @param {Object} elem
         */
        function removeChildElems(elem) {
            while (elem.firstChild) {
                elem.removeChild(elem.firstChild);
            }
        }

        /**
         * Check, if the flag for an existing config is set
         * @returns {boolean}
         */
        function serverConfigExists() {
            return document.getElementsByName("mumie_missing_config")[0].getAttribute("value") === "";
        }

        var isEdit = document.getElementById("mumie_name").getAttribute('value');

        if (isEdit && !serverConfigExists()) {
            serverController.disable();
            courseController.disable();
            langController.disable();
            taskController.disable();
            problemSelectorController.disable();
        } else {
            serverController.init(JSON.parse(`<?=json_encode($serverStructure);?>`));
            courseController.init(isEdit);
            taskController.init(isEdit);
            langController.init();
            problemSelectorController.init();
        }
    })();
</script>