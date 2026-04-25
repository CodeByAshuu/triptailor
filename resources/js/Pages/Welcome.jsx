import { Head, Link } from '@inertiajs/react';
import ApplicationLogo from '@/Components/ApplicationLogo';

export default function Welcome({ auth }) {
    return (
        <>
            <Head title="Welcome" />

            <div className="min-h-screen bg-[#F5EFE6] text-[#3E3024]">
                <div className="mx-auto w-full max-w-7xl px-6 py-8">
                    <header className="flex items-center justify-between border-b border-[#D8CFC3] pb-4">
                        <div className="flex items-center gap-3">
                            <ApplicationLogo className="h-10 w-auto" />
                            <h1 className="text-2xl font-bold tracking-tight">TripTailor</h1>
                        </div>

                        <nav className="flex items-center gap-2">
                            {auth?.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="rounded-md bg-[#3E3024] px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="rounded-md px-4 py-2 text-sm font-medium hover:bg-[#E8DFD3]"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="rounded-md bg-[#3E3024] px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </nav>
                    </header>

                    <main className="py-14">
                        <section className="mb-12">
                            <h2 className="text-4xl font-extrabold leading-tight md:text-5xl">
                                Plan better trips with less effort
                            </h2>
                            <p className="mt-4 max-w-2xl text-base text-[#5A4A3D]">
                                TripTailor helps you create itineraries, manage budget, and keep
                                all travel details in one place.
                            </p>
                        </section>

                        <section className="grid gap-5 md:grid-cols-3">
                            <div className="rounded-xl border border-[#D8CFC3] bg-[#FFF9F2] p-5">
                                <h3 className="text-lg font-semibold">Smart Itinerary</h3>
                                <p className="mt-2 text-sm text-[#5A4A3D]">
                                    Build day-wise plans quickly and edit anytime.
                                </p>
                            </div>

                            <div className="rounded-xl border border-[#D8CFC3] bg-[#FFF9F2] p-5">
                                <h3 className="text-lg font-semibold">Budget Tracking</h3>
                                <p className="mt-2 text-sm text-[#5A4A3D]">
                                    Set trip budget and track expenses in one view.
                                </p>
                            </div>

                            <div className="rounded-xl border border-[#D8CFC3] bg-[#FFF9F2] p-5">
                                <h3 className="text-lg font-semibold">Bookings & Notes</h3>
                                <p className="mt-2 text-sm text-[#5A4A3D]">
                                    Store hotels, transport, and important trip notes.
                                </p>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </>
    );
}
