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
        <div id="mumie_filter_section">
            <div id="mumie_filter_header" class="mumie-collapsable">
                <i class="fa fa-caret-down mumie-icon"></i>
                <?=dgettext("MumieTaskPlugin", "Filter MUMIE-Tasks");?>
            </div>
            <div id="mumie_filter_wrapper">
            </div>
        </div>
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

        var serverController = (function() {
            var serverStructure;
            var serverDropDown = document.getElementById("mumie_server");

            return {
                init: function(structure) {
                    serverStructure = structure;
                    serverDropDown.onchange = function() {
                        courseController.updateOptions();
                        langController.updateOptions();
                        filterController.updateOptions();
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
                        filterController.updateOptions();
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
                    var tasks = filterController.filterTasks(courseController.getSelectedCourse()
                        .tasks);
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

        var filterController = (function() {
            var filterSection = document.getElementById('mumie_filter_section');
            var filterWrapper = document.getElementById("mumie_filter_wrapper");
            var filterSectionHeader = document.getElementById('mumie_filter_header');

            var selectedTags = [];

            /**
             * Add a new filter category to the form for a given tag
             * @param {Object} tag
             */
            function addFilter(tag) {
                var filter = document.createElement('div');
                filter.classList.add('row', 'fitem', 'form-group', 'mumie-filter');

                var selectionBox = createSelectionBox(tag);

                var label = document.createElement('label');
                label.innerHTML = '<i class="fa fa-caret-down mumie-icon"></i>' + tag.name;
                label.classList.add('mumie-collapsable', 'mumie_label');
                label.onclick = function() {
                    toggleVisibility(selectionBox);
                };
                filter.appendChild(label);
                filter.appendChild(selectionBox);
                filterWrapper.appendChild(filter);
            }

            /**
             * Create an element that contains checkboxes for all tag values
             * @param {Object} tag
             * @returns {Object} A div containing mulitple checkboxes
             */
            function createSelectionBox(tag) {
                var selectionBox = document.createElement('div');
                selectionBox.classList.add('mumie_selection_box');
                for (var i in tag.values) {
                    selectedTags[tag.name] = [];
                    var inputWrapper = document.createElement('div');
                    inputWrapper.classList.add('mumie_input_wrapper');

                    var value = tag.values[i];
                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = value;
                    setCheckboxListener(tag, checkbox);

                    var label = document.createElement('label');
                    label.classList.add('mumie_label');
                    label.innerText = value;
                    label.style = "padding-left: 5px";
                    inputWrapper.appendChild(checkbox);
                    inputWrapper.appendChild(label);
                    selectionBox.insertBefore(inputWrapper, selectionBox.firstChild);
                }
                return selectionBox;
            }

            /**
             * Selecting a tag value should filter the drop down menu for MUMIE problems for the chosen values
             * @param {*} tag The tag we created the checkbox for
             * @param {*} checkbox The checkbox containing the filter input checkboxes
             */
            function setCheckboxListener(tag, checkbox) {
                checkbox.onclick = function() {
                    if (!checkbox.checked) {
                        var update = [];
                        for (var i in selectedTags[tag.name]) {
                            var value = selectedTags[tag.name][i];
                            if (value != checkbox.value) {
                                update.push(value);
                            }
                        }
                        selectedTags[tag.name] = update;
                    } else {
                        selectedTags[tag.name].push(checkbox.value);
                    }
                    taskController.updateOptions();
                };
            }

            /**
             * Toggle visibility of the given object
             * @param {Object} elem
             */
            function toggleVisibility(elem) {
                elem.classList.toggle('hidden');
            }

            /**
             * Filter a list of tasks
             * @param {Array} tasks the tasks to filter
             * @param {Array} filterSelection the selection to filter with
             * @returns {Array} the filtered tasks
             */
            function filterTasks(tasks, filterSelection) {
                var filteredTasks = [];
                for (var i in tasks) {
                    var task = tasks[i];
                    if (filterTask(task, filterSelection)) {
                        filteredTasks.push(task);
                    }
                }
                return filteredTasks;
            }

            /**
             * Check if the task fullfills the requirements set by the filter selection
             * @param {Object} task
             * @param {Array} filterSelection
             * @returns {boolean}
             */
            function filterTask(task, filterSelection) {
                var obj = [];
                for (var i in task.tags) {
                    var tag = task.tags[i];
                    obj[tag.name] = tag.values;
                }

                for (var j in Object.keys(filterSelection)) {
                    var tagName = Object.keys(filterSelection)[j];
                    if (filterSelection[tagName].length == 0) {
                        continue;
                    }
                    if (!obj[tagName]) {
                        return false;
                    }
                    if (!haveCommonEntry(filterSelection[tagName], obj[tagName])) {
                        return false;
                    }
                }
                return true;
            }

            /**
             * Return true, of the two arrays have at least one entry in common
             * @param {Array} array1
             * @param {Array} array2
             * @returns {boolean}
             */
            function haveCommonEntry(array1, array2) {
                if (!Array.isArray(array1) || !Array.isArray(array2)) {
                    return false;
                }
                for (var i = 0; i < array1.length; i++) {
                    if (array2.includes(array1[i])) {
                        return true;
                    }
                }
                return false;
            }

            return {
                init: function() {
                    this.updateOptions();
                    filterSectionHeader.onclick = function() {
                        toggleVisibility(filterWrapper);
                    };
                },
                updateOptions: function() {
                    var tags = courseController.getSelectedCourse().tags;
                    selectedTags = [];
                    if (tags.length > 0) {
                        filterSection.hidden = false;
                    } else {
                        filterSection.hidden = true;
                    }
                    removeChildElems(filterWrapper);
                    for (var i in tags) {
                        var tag = tags[i];
                        addFilter(tag);
                    }
                },
                filterTasks: function(tasks) {
                    return filterTasks(tasks, selectedTags);
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
        } else {
            serverController.init(JSON.parse('<?=json_encode($serverStructure);?>'));
            courseController.init(isEdit);
            taskController.init(isEdit);
            langController.init();
            filterController.init();
        }
    })();
</script>