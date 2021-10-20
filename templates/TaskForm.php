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
            <input id="mumie_name" required type="text" name="name" value="<?= htmlspecialchars($name)?>">
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
            <input type="text" id="mumie_course" name="course" disabled />
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
        <input type="hidden" id="language" name="language" value=<?= $language ?? $_SESSION['_language'];?>>
        <input type="hidden" name="task_url" id="mumie_taskurl" value=<?= $task_url;?>>
        <input type="hidden" name="is_graded" id="mumie_is_graded" value=<?= $is_graded;?>>
        <label for="display_task">
            <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'MUMIE-Aufgabe'); ?>
                </span>
        </label>

        <input type="text" name="display_task" id="mumie_display_task" disabled>
        <?=
            Icon::create(
                'info',
                'info',
                [
                    'title' => dgettext("MumieTaskPlugin", "Eine MUMIE-Aufgabe kann durch Studierende bearbeitet werden und wird einzeln benotet.")
                ]
            )->asImg();
        ?>
        <br>
        <a id="mumie_prb_selector_btn" class="button"><?= dgettext("MumieTaskPlugin", "Aufgaben-Auswahl öffnen");?></a>
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
        <div class="mumie_form_elem_wrapper" id="mumie_ungraded_info" hidden?>>
            <b>
                <?= dgettext('MumieTaskPlugin', 'Die gewählte Aufgabe ist unbewertet. Daher sind die Bewertungseinstellungen deaktiviert') ?>
            </b>
        </div>
        <legend><?= dgettext('MumieTaskPlugin', 'Benotung'); ?></legend>
        <div class="mumie_form_elem_wrapper">
            <label for="mumie_passing_grade">
                <?= dgettext('MumieTaskPlugin', 'Bestehensgrenze'); ?>
            </label>
            <input
                    type="number"
                    name="passing_grade"
                    id="mumie_passing_grade"
                    min="0"
                    max="100"
                    value="<?= $passing_grade ?? 60;?>"
            >
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
            <input
                    type="text"
                    name="duedate"
                    id="mumie_due_date"
                    data-datetime-picker
                    value="<?= $duedate == 0 ? null : date('d.m.Y H:i', $duedate);?>"
            >
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
        const missingConfig = document.getElementsByName("mumie_missing_config")[0];
        // const lmsSelectorUrl = 'https://pool.mumie.net';
        const lmsSelectorUrl = 'http://localhost:7070';

        const serverController = (function() {
            let serverStructure;
            const serverDropDown = document.getElementById("mumie_server");

            return {
                init: function (structure) {
                    serverStructure = structure;
                },
                getSelectedServer: function () {
                    const selectedServerName = serverDropDown.options[serverDropDown.selectedIndex].text;
                    return serverStructure.find(server => server.name === selectedServerName);
                },
                disable: function () {
                    serverDropDown.disabled = true;
                    removeChildElements(serverDropDown);
                },
                getAllServers: function () {
                    return serverStructure;
                }
            };
        })();

        const courseController = (function() {
            const courseNameElem = document.getElementById("mumie_course");
            const coursefileElem = document.getElementById("mumie_coursefile");

            /**
             * Update the hidden input field with the selected course's course file path
             */
            function updateCoursefilePath(coursefile) {
                coursefileElem.value = coursefile;
                updateCourseName();
            }

            /**
             * Update displayed course name.
             */
            function updateCourseName() {
                const selectedCourse = courseController.getSelectedCourse();
                const selectedLanguage = langController.getSelectedLanguage();
                if (!selectedCourse || !selectedLanguage) {
                    return;
                }
                courseNameElem.value = selectedCourse.name
                    .find(translation => translation.language === selectedLanguage)?.value;
            }

            return {
                init: function () {
                    updateCourseName();
                },
                getSelectedCourse: function () {
                    const courses = serverController.getSelectedServer().courses;
                    return courses.find(course => {
                        return course.coursefile === coursefileElem.value;
                    })
                },
                updateCourseName: function () {
                    updateCourseName();
                },
                setCourse: function (courseFile) {
                    updateCoursefilePath(courseFile);
                }
            };
        })();

        const langController = (function () {
            const languageElement = document.getElementById("language");

            return {
                getSelectedLanguage: function () {
                    return languageElement.value;
                },
                setLanguage: function (lang) {
                    if (!courseController.getSelectedCourse().languages.includes(lang)) {
                        throw new Error("Selected language not available");
                    }
                    languageElement.value = lang;
                    courseController.updateCourseName();
                }
            };
        })();

        const taskController = (function () {
            const task_element = document.getElementById("mumie_taskurl");
            const display_task_element = document.getElementById("mumie_display_task");
            const nameElem = document.getElementById("mumie_name");
            const is_graded_element = document.getElementById("mumie_is_graded");

            /**
             * Update the activity's name in the input field
             */
            function updateName() {
                const newHeadline = getHeadline(taskController.getSelectedTask());
                if (!isCustomName()) {
                    nameElem.value = newHeadline;
                }
                display_task_element.value = newHeadline;
            }

            /**
             * Check whether the activity has a custom name
             *
             * @return {boolean} True, if there is no headline with that name in all tasks
             */
            function isCustomName() {
                if (nameElem.value.length === 0) {
                    return false;
                }
                return !getAllHeadlines().includes(nameElem.value);
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
                const selectedLanguage = langController.getSelectedLanguage();
                const headlineWrapper = task.headline.find(localHeadline => localHeadline.language === selectedLanguage);
                return headlineWrapper ? headlineWrapper.name : null;
            }

            /**
             * Get all tasks that are available on all servers
             *
             * @return {Object} Array containing all available tasks
             */
            function getAllTasks() {
                return serverController.getAllServers()
                    .flatMap(server => server.courses)
                    .flatMap(course => course.tasks);
            }

            /**
             * Add language parameter to link
             * @param {string} link
             * @returns {string}
             */
            function getLocalizedLink(link) {
                return link + "?lang=" + langController.getSelectedLanguage();
            }

            /**
             * Get all possible headlines in all languages
             * @returns {Object} Array containing all headlines
             */
            function getAllHeadlines() {
                return getAllTasks().flatMap(task => task.headline)
                    .map(headline => headline.name)
                    .concat(courseController.getSelectedCourse().name.map(n => n.value))
            }

            function updateGradeEditability() {
                const isUngraded = is_graded_element.value === '0';
                document.getElementById('mumie_passing_grade').disabled = isUngraded;
                document.getElementById('mumie_due_date').disabled = isUngraded;
                document.getElementById('mumie_ungraded_info').hidden = !isUngraded;
            }

            return {
                init: function () {
                    updateName();
                    updateGradeEditability();
                },
                getSelectedTask: function () {
                    const selectedLink = task_element.value
                    const selectedCourse = courseController.getSelectedCourse();
                    if (!selectedCourse) {
                        return null;
                    }
                    return selectedCourse
                        .tasks
                        .slice()
                        .find(task => getLocalizedLink(task.link) === selectedLink);
                },
                setIsGraded: function(isGraded) {
                    if (isGraded === null) {
                        is_graded_element.value = null;
                    }
                    is_graded_element.value = isGraded ? '1' : '0';
                    updateGradeEditability();
                },
                setSelection: function(newSelection) {
                    task_element.value = newSelection;
                    updateName();
                },
                getGradingType: function() {
                    const isGraded = is_graded_element.value;
                    if (isGraded === '1') {
                        return 'graded';
                    } else if (isGraded === '0') {
                        return 'ungraded';
                    }
                    return 'all';
                }
            };
        })();

        const problemSelectorController = (function() {
            const problemSelectorButton = document.getElementById('mumie_prb_selector_btn');
            let problemSelectorWindow;
            const mumieOrg = `<?= $mumieOrg; ?>`;

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
                    event.preventDefault();
                    if (event.origin !== lmsSelectorUrl) {
                        return;
                    }
                    const importObj = JSON.parse(event.data);
                    const isGraded = importObj.isGraded !== false;
                    try {
                        courseController.setCourse(importObj.path_to_coursefile);
                        langController.setLanguage(importObj.language);
                        taskController.setSelection(importObj.link + '?lang=' + importObj.language);
                        taskController.setIsGraded(isGraded);
                        sendSuccess();
                        window.focus();
                    } catch (error) {
                        console.error(error.message);
                        sendFailure(error.message);
                    }
                }, false);
            }

            return {
                init: function () {
                    problemSelectorButton.onclick = function (e) {
                        e.preventDefault();
                        const selectedTask = taskController.getSelectedTask();
                        const gradingType = taskController.getGradingType();
                        problemSelectorWindow = window.open(
                            lmsSelectorUrl
                            + '/lms-problem-selector?'
                            + 'org='
                            + mumieOrg
                            + '&serverUrl='
                            + encodeURIComponent(serverController.getSelectedServer().url_prefix)
                            + "&problemLang="
                            + langController.getSelectedLanguage()
                            + (selectedTask ? "&problem=" + selectedTask.link : '')
                            + "&origin=" + encodeURIComponent(window.location.origin)
                            + '&multiCourse=true'
                            + '&gradingType=' + gradingType
                            , '_blank'
                        );
                    };

                    window.onclose = function () {
                        sendSuccess();
                    };

                    window.addEventListener("beforeunload", function () {
                        sendSuccess();
                    }, false);

                    addMessageListener();
                },
                disable: function () {
                    problemSelectorButton.disabled = true;
                }
            };
        })();

        /**
         * Remove all child elements of a given html element
         * @param {Object} elem
         */
        function removeChildElements(elem) {
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
            taskController.disable();
            problemSelectorController.disable();
        } else {
            serverController.init(JSON.parse(`<?= addslashes(json_encode($serverStructure));?>`));
            courseController.init();
            taskController.init(isEdit);
            problemSelectorController.init();
        }
    })();
</script>
