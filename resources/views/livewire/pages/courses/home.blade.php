<x-app-layout>
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

    <x-courses.upcoming-events
        :latestEvents="$latestEvents" />

    <div class="px-8 mt-10 pb-10">
        <flux:heading size="lg" class="mb-6">
            Top Students
        </flux:heading>
        <x-.courses.leaderboard.list
            :leaders="$topStudents" />
    </div>
</x-app-layout>