@extends('components.layouts.app')
@section('content')

    <!-- Location -->
    <div class="location-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="location-item">
                        <i class='bx bx-phone-call'></i>
                        <h3>Contact Number</h3>
                        <span>Dial And Get Solution:</span>
                        <a href="tel:+123456789">+09612139536</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="location-item">
                        <i class='bx bx-location-plus'></i>
                        <h3>Our Location</h3>
                        <span>Find Our Office:</span>
                        <span>2nd Street, Barangay Katuparan, Taguig City, Philippines</span>
                    </div>
                </div>
                <div class="col-sm-6 offset-sm-3 offset-lg-0 col-lg-4">
                    <div class="location-item">
                        <i class='bx bx-mail-send'></i>
                        <h3>Our Email</h3>
                        <span>Mail Us Anytime:</span>
                        <a href="mailto:info@lixi.com">washease@gmail.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Location -->

    <!-- Contact -->
    <div class="contact-area pb-100">
        <div class="container">
            <div class="section-title">
                <h2>Get In Touch</h2>
            </div>
            <form id="contactForm">
                <div class="row">
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone_number" id="phone_number" required data-error="Please enter your number" class="form-control">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="msg_subject" id="msg_subject" class="form-control" required data-error="Please enter your subject">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" id="message" cols="30" rows="8" required data-error="Write your message"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <div class="form-check agree-label">
                                <input
                                    name="gridCheck"
                                    value="I agree to the terms and privacy policy."
                                    class="form-check-input"
                                    type="checkbox"
                                    id="gridCheck"
                                    required
                                >

                                <label class="form-check-label" for="gridCheck">
                                    Accept <a href="terms-and-conditions">Terms & Conditions</a> And <a href="privacy-policy.html">Privacy Policy.</a>
                                </label>
                                <div class="help-block with-errors gridCheck-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <button type="submit" class="cmn-btn btn">
                            Send Message
                        </button>
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Contact -->

@endsection
@pushonce('scripts')
    <script>
        console.log('Welcome page');
    </script>
@endpushonce
