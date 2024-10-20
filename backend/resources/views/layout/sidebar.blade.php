<div x-data="{ isOpen: false, activeMenu: null }" class="flex h-screen">

    <div class="p-4">
        <svg @click="isOpen = !isOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor"
            class="w-8 h-8 cursor-pointer text-gray-800 hover:text-gray-600 transition">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </div>

    <aside x-show="isOpen" x-transition
        class="w-64 bg-gray-900 text-white h-screen fixed top-0 left-0 z-40 transform transition-transform duration-300"
        :class="isOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="p-4 flex justify-between items-center border-b border-gray-700">
            <h2 class="text-xl font-bold">University Admin</h2>
            <svg @click="isOpen = false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <ul class="mt-6 space-y-2">

            <li class="group">
                <a @click="activeMenu === 'students' ? activeMenu = null : activeMenu = 'students'" href="#"
                    class="flex justify-between items-center p-2 hover:bg-gray-800 transition rounded-md">
                    <span class="flex items-center">
                        <i class="fas fa-user-graduate mr-2"></i> Students
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 transition-transform"
                        :class="activeMenu === 'students' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                    </svg>
                </a>
                <ul x-show="activeMenu === 'students'" x-transition class="space-y-1 mt-1 pl-6">
                    <li><a href="{{ route('admin.getCreateStudentForm') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Create Student</a></li>
                    <li><a href="{{ route('admin.getStudents') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Show Students</a></li>
                </ul>
            </li>

            <li class="group">
                <a @click="activeMenu === 'professors' ? activeMenu = null : activeMenu = 'professors'" href="#"
                    class="flex justify-between items-center p-2 hover:bg-gray-800 transition rounded-md">
                    <span class="flex items-center">
                        <i class="fas fa-chalkboard-teacher mr-2"></i> Professors
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 transition-transform"
                        :class="activeMenu === 'professors' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                    </svg>
                </a>
                <ul x-show="activeMenu === 'professors'" x-transition class="space-y-1 mt-1 pl-6">
                    <li><a href="{{ route('admin.getCreateProfessor') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Create Professor</a></li>
                    <li><a href="{{ route('professors.show') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Show Professors</a></li>
                </ul>
            </li>

            <li class="group">
                <a @click="activeMenu === 'departments' ? activeMenu = null : activeMenu = 'departments'" href="#"
                    class="flex justify-between items-center p-2 hover:bg-gray-800 transition rounded-md">
                    <span class="flex items-center">
                        <i class="fas fa-building mr-2"></i> Departments
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 transition-transform"
                        :class="activeMenu === 'departments' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                    </svg>
                </a>
                <ul x-show="activeMenu === 'departments'" x-transition class="space-y-1 mt-1 pl-6">
                    <li><a href="{{ route('dept.getForm') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Create Department</a></li>
                    <li><a href="{{ route('dept.get') }}" class="block p-2 hover:bg-gray-700 transition rounded-md">Show
                            Departments</a></li>
                </ul>
            </li>

            <li class="group">
                <a @click="activeMenu === 'courses' ? activeMenu = null : activeMenu = 'courses'" href="#"
                    class="flex justify-between items-center p-2 hover:bg-gray-800 transition rounded-md">
                    <span class="flex items-center">
                        <i class="fas fa-book mr-2"></i> Courses
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 transition-transform"
                        :class="activeMenu === 'courses' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                    </svg>
                </a>
                <ul x-show="activeMenu === 'courses'" x-transition class="space-y-1 mt-1 pl-6">
                    <li><a href="{{ route('course.getForm') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Create Course</a></li>
                    <li><a href="{{ route('course.get') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Show Courses</a></li>
                </ul>
            </li>

            <li class="group">
                <a @click="activeMenu === 'classrooms' ? activeMenu = null : activeMenu = 'classrooms'" href="#"
                    class="flex justify-between items-center p-2 hover:bg-gray-800 transition rounded-md">
                    <span class="flex items-center">
                        <i class="fas fa-school mr-2"></i> Classrooms
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 transition-transform"
                        :class="activeMenu === 'classrooms' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                    </svg>
                </a>
                <ul x-show="activeMenu === 'classrooms'" x-transition class="space-y-1 mt-1 pl-6">
                    <li><a href="{{ route('classroom.getForm') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Create Classroom</a></li>
                    <li><a href="{{ route('classroom.show') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Show Classrooms</a></li>
                </ul>
            </li>

            <li class="group">
                <a @click="activeMenu === 'enrollments' ? activeMenu = null : activeMenu = 'enrollments'"
                    href="#"
                    class="flex justify-between items-center p-2 hover:bg-gray-800 transition rounded-md">
                    <span class="flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> Enrollments
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 transition-transform"
                        :class="activeMenu === 'enrollments' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                    </svg>
                </a>
                <ul x-show="activeMenu === 'enrollments'" x-transition class="space-y-1 mt-1 pl-6">
                    <li><a href="{{ route('enrollment.getForm') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Create Enrollment</a></li>
                    <li><a href="{{ route('enrollment.show') }}"
                            class="block p-2 hover:bg-gray-700 transition rounded-md">Show Enrollments</a></li>
                </ul>
            </li>
    <li class="ml-2 mt-5">
    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
        @csrf  
        <button type="submit" class="flex items-center p-3 text-gray-200 hover:bg-gray-700 hover:text-white transition-colors duration-200 rounded-md w-full text-left">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m0 0l4-4m-4 4l4 4m16-12v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2h16a2 2 0 012 2z" />
            </svg>
            Logout
        </button>
    </form>
</li>



        </ul>
    </aside>

    <main class="flex-1 p-10 bg-gray-100">

    </main>
</div>
