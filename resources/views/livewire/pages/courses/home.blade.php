<x-app-layout>
    <div
        x-data="{
            openBuyModal:false,
            selectedCourse:null
        }"
        @open-buy-modal.window="
            selectedCourse = $event.detail;
            openBuyModal = true;
        ">
        <x-courses.header
            :user="$user"
            :members="$members"
            :total-students="$totalStudents" />

        <x-courses.stats-cards
            :user="$user"
            :current-rank="$user->rank['name']"
            :points="$user->points"
            :my-courses="$myCourses"
            :completed-courses="$completedCourses" />

        <x-courses.popular-courses
            :topCourses="$topCourses" />

        <x-courses.buy-course-modal />

        <x-courses.upcoming-events
            :latestEvents="$latestEvents" />

        <div class="mt-10 pb-10">
            <flux:heading size="lg" class="mb-6">
                Top Students
            </flux:heading>
            <x-.courses.leaderboard.list
                :leaders="$topStudents" />
        </div>
    </div>
</x-app-layout>