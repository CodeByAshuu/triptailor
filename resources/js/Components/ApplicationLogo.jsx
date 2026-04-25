export default function ApplicationLogo({ className = '', ...props }) {
    return (
        <img
            {...props}
            src="/images/logo.jpeg"
            alt="TripTailor Logo"
            className={`h-12 w-auto ${className}`}
        />
    );
}
