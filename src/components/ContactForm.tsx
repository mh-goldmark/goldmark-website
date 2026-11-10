"use client";

import { FormEvent, useState } from "react";

export default function ContactForm() {
  const [submitted, setSubmitted] = useState(false);

  function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setSubmitted(true);
  }

  if (submitted) {
    return (
      <div className="mx-auto mt-12 max-w-3xl rounded-md border border-gold/40 bg-white/5 px-6 py-10 text-center">
        <p className="font-heading text-2xl text-gold">Thank you</p>
        <p className="mt-3 font-sans text-sm leading-relaxed text-beige/85 md:text-base">
          Your enquiry has been recorded locally for this preview. CRM handoff
          and live routing will follow in a later phase.
        </p>
      </div>
    );
  }

  return (
    <form
      className="mx-auto mt-12 grid max-w-3xl gap-5 md:grid-cols-2"
      onSubmit={handleSubmit}
    >
      <label className="block md:col-span-1">
        <span className="mb-2 block font-sans text-xs font-semibold uppercase tracking-[0.14em] text-beige/70">
          Full name
        </span>
        <input
          required
          name="name"
          type="text"
          autoComplete="name"
          className="w-full rounded-md border border-white/15 bg-white/5 px-4 py-3 font-sans text-sm text-off-white outline-none transition placeholder:text-white/35 focus:border-gold"
          placeholder="Your name"
        />
      </label>
      <label className="block md:col-span-1">
        <span className="mb-2 block font-sans text-xs font-semibold uppercase tracking-[0.14em] text-beige/70">
          Email
        </span>
        <input
          required
          name="email"
          type="email"
          autoComplete="email"
          className="w-full rounded-md border border-white/15 bg-white/5 px-4 py-3 font-sans text-sm text-off-white outline-none transition placeholder:text-white/35 focus:border-gold"
          placeholder="you@company.com"
        />
      </label>
      <label className="block md:col-span-1">
        <span className="mb-2 block font-sans text-xs font-semibold uppercase tracking-[0.14em] text-beige/70">
          Phone
        </span>
        <input
          name="phone"
          type="tel"
          autoComplete="tel"
          className="w-full rounded-md border border-white/15 bg-white/5 px-4 py-3 font-sans text-sm text-off-white outline-none transition placeholder:text-white/35 focus:border-gold"
          placeholder="+971 ..."
        />
      </label>
      <label className="block md:col-span-1">
        <span className="mb-2 block font-sans text-xs font-semibold uppercase tracking-[0.14em] text-beige/70">
          Interest
        </span>
        <select
          name="interest"
          className="w-full rounded-md border border-white/15 bg-navy px-4 py-3 font-sans text-sm text-off-white outline-none transition focus:border-gold"
          defaultValue="tour"
        >
          <option value="tour">Book a Tour</option>
          <option value="quote">Get a Quote</option>
          <option value="private">Private Office</option>
          <option value="coworking">Coworking</option>
          <option value="meeting">Meeting Room</option>
        </select>
      </label>
      <label className="block md:col-span-2">
        <span className="mb-2 block font-sans text-xs font-semibold uppercase tracking-[0.14em] text-beige/70">
          Message
        </span>
        <textarea
          name="message"
          rows={4}
          className="w-full resize-y rounded-md border border-white/15 bg-white/5 px-4 py-3 font-sans text-sm text-off-white outline-none transition placeholder:text-white/35 focus:border-gold"
          placeholder="Team size, preferred dates, or questions..."
        />
      </label>
      <div className="md:col-span-2">
        <button
          type="submit"
          className="inline-flex w-full items-center justify-center rounded-md bg-gold px-7 py-3.5 font-sans text-sm font-semibold tracking-[0.06em] text-navy transition duration-300 hover:bg-[#e0c04a] sm:w-auto"
        >
          Send Enquiry
        </button>
        <p className="mt-4 font-sans text-xs leading-relaxed text-beige/55">
          By submitting, you consent to Gold Mark Work Life contacting you about
          this enquiry. CRM integration follows in a later phase.
        </p>
      </div>
    </form>
  );
}
