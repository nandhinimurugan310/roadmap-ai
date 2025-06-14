<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aryng AI Roadmap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f9fafb;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        .split-container {
            max-width: 1000px;
            margin: auto;
            margin-top: 5vh;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
        }

        .left-panel {
            background-color: #1f2937;
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel h2 {
            font-weight: bold;
        }

        .left-panel p {
            font-size: 0.95rem;
            color: #d1d5db;
        }

        .right-panel {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 500;
        }

        .error-msg {
            font-size: 0.85rem;
            color: #dc3545;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.15rem rgba(13,110,253,.2);
        }

        @media (max-width: 768px) {
            .split-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container px-3">
    <div class="d-flex split-container flex-column flex-md-row">
        <!-- LEFT PANEL -->
        <div class="left-panel col-md-5 text-center">
            <div>
                <h2 class="mb-3">Welcome to Aryng AI</h2>
                <p class="mb-4">Discover your personalized AI roadmap.<br> Let our assistant guide you, step by step.</p>
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712106.png" width="120" class="img-fluid" alt="AI Icon">
            </div>
        </div>

        <!-- RIGHT PANEL: FORM -->
        <div class="right-panel col-md-7">
            <h4 class="mb-4 text-center">🚀 Get Your AI Roadmap</h4>

            <form method="POST" action="{{ route('submit.form') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" required>
                        @error('first_name') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" required>
                        @error('last_name') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control @error('company_name') is-invalid @enderror" required>
                    @error('company_name') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Industry</label>
                    <input type="text" name="industry" value="{{ old('industry') }}" class="form-control @error('industry') is-invalid @enderror">
                    @error('industry') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Company Size</label>
                    <select name="company_size" class="form-control @error('company_size') is-invalid @enderror" required>
                        <option value="">Select</option>
                        @foreach(['1-10', '11-50', '51-200', '200+'] as $size)
                            <option value="{{ $size }}" {{ old('company_size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    @error('company_size') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Job Title</label>
                    <input type="text" name="job_title" value="{{ old('job_title') }}" class="form-control @error('job_title') is-invalid @enderror" required>
                    @error('job_title') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">💬 Start Chat</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
