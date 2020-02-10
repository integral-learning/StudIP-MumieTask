
<form class="default" action="<?= $action; ?>" method="post">
    <label>
        <span class="required">
            <?= dgettext('MumieTask', 'Name'); ?>
        </span> 
        <input id="mumie_name" required type="text" name="name" value="<?= $name?>" placeholder="<?= dgettext('MumieTask', 'Legen Sie einen Namen für die Server-Konfiguration fest'); ?>" >
    </label>
    <label>
        <span class="required">
            <?= dgettext('MumieTask', 'MUMIE-Server'); ?>
        </span> 
        <select id="mumie_server" name="server">
            <? 
                $options = $collector->getServerOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> <?= $key == $server ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'MUMIE-Kurs'); ?>
        <select id="mumie_course" name="course">
            <? 
                $options = $collector->getCourseOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> <?= $key == $mumie_course ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
        </select>
    </label>
    <input type="hidden" id="mumie_coursefile" name = "coursefile" value=<?= $mumie_coursefile;?>>
    <label>
        <?= dgettext('MumieTask', 'Sprache'); ?>
        <select id="mumie_language" name="language">
            <? 
                $options = $collector->getLangOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> <?= $key == $language ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'MUMIE-Aufgabe'); ?>
        <select id="mumie_taskurl" name="task_url">
            <? 
                $options = $collector->getTaskOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> <?= $key == $task_url ? "selected = 'selected'" :"";?>>
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'Startcontainer'); ?>
        <select name="launch_container">
            <option value="1" <?= $launch_container == 1 ? "selected = 'selected'" :"";?>>Eingebunden</option>
            <option value="0" <?= $launch_container == 0 ? "selected = 'selected'" :"";?>>Neuer Browser-Tab</option>
        </select>
    </label>
        <?= \Studip\Button::create(dgettext('MumieTask', 'Einfügen')); ?>
</form>

<script>

(function() {
        //ar addServerButton = document.getElementById("id_add_server_button");
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
                optionCourse.setAttribute("value", course.name);
                optionCourse.text = course.name;
                courseDropDown.append(optionCourse);
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
                        if (course.name == selectedCourseName) {
                            return course;
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
                    taskDropDown.options[taskDropDown.selectedIndex].getAttribute('value') + "?lang=" + langController.getSelectedLanguage() : undefined
                    );
                },
                getSelectedTask: function() {
                    var selectedLink = taskDropDown.options[taskDropDown.selectedIndex] ==
                        undefined ? undefined : taskDropDown.options[taskDropDown.selectedIndex].getAttribute('value');
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
                    var tasks = filterController.filterTasks(courseController.getSelectedCourse().tasks);
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
                label.classList.add('col-md-3', 'mumie-collapsable');
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
                selectionBox.classList.add('col-md-9', 'felement', 'mumie_selection_box');
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
                elem.toggleAttribute('hidden');
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
            return true;
            //return document.getElementsByName("mumie_missing_config")[0].getAttribute("value") === "";
        }

        var isEdit = document.getElementById("mumie_name").getAttribute('value');
        console.log("hallo");

        if (isEdit && !serverConfigExists()) {
            /*
            require(['core/str', "core/notification"], function(str, notification) {
                str.get_strings([{
                    'key': 'mumie_form_missing_server',
                    component: 'mod_mumie'
                }]).done(function(s) {
                    notification.addNotification({
                        message: s[0] + "<b>" + missingConfig.getAttribute("value") + "</b>",
                        type: "problem"
                    });
                }).fail(notification.exception);
            });
            */
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
                /*
                if (addServerButton) {
                    require(['auth_mumie/mumie_server_config'], function(MumieServer) {
                        MumieServer.init(addServerButton, contextid);
                    });
                }
                */
    })();
</script>