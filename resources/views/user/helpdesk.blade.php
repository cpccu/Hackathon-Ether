


<section id="section-helpdesk" class="page-section">

    <div>

        <div class="section-label">
            Support
        </div>

        <h2 class="text-2xl sm:text-3xl font-black mt-1">
            Helpdesk
        </h2>

        <p class="text-sm text-muted mt-2">
            Submit a complaint or check your previous requests.
        </p>

    </div>


    <div class="grid xl:grid-cols-[1fr_.8fr] gap-5 mt-6">


        <!-- Complaint Form -->

        <div class="soft-card rounded-[24px] sm:rounded-[26px] p-4 sm:p-6">

            <h3 class="text-xl font-black">
                Submit a Complaint
            </h3>

            <p class="text-sm text-muted mt-1">
                Tell the university administration about an issue.
            </p>


            <form
                action="{{ route('user.complaint.store') }}"
                method="POST"
                class="space-y-4 mt-6"
            >

                @csrf

                <div>

                    <label class="text-xs font-bold">
                        Complaint Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        required
                        placeholder="Enter complaint title"
                        class="input-field"
                    >

                </div>


                <div>

                    <label class="text-xs font-bold">
                        Details
                    </label>

                    <textarea
                        name="short_description"
                        rows="6"
                        required
                        placeholder="Explain your issue..."
                        class="input-field"
                    ></textarea>

                </div>


                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-wine hover:bg-wineDark text-white text-sm font-bold"
                >
                    Submit Complaint
                </button>

            </form>

        </div>


        <!-- History -->

        <div class="soft-card rounded-[24px] sm:rounded-[26px] p-4 sm:p-6">

            <h3 class="text-xl font-black">
                My Complaints
            </h3>

            <div class="space-y-3 mt-5">

                @forelse($myComplaints as $comp)

                    <div
                        class="cream-card rounded-2xl p-4"
                        data-search-item
                        data-search-section="helpdesk"
                        data-search-text="{{ strtolower($comp->title . ' ' . $comp->short_description) }}"
                    >

                        <div class="flex justify-between gap-3">

                            <h4 class="font-bold text-sm">
                                {{ $comp->title }}
                            </h4>

                            <span class="text-[10px] text-muted whitespace-nowrap">
                                {{ $comp->created_at->diffForHumans() }}
                            </span>

                        </div>

                        <p class="text-xs text-muted mt-2">
                            {{ $comp->short_description }}
                        </p>

                    </div>

                @empty

                    <div class="cream-card rounded-2xl p-6 text-center">

                        <p class="font-bold text-sm">
                            No complaints yet
                        </p>

                        <p class="text-xs text-muted mt-1">
                            Your submitted complaints will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</section>

