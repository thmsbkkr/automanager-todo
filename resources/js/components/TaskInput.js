import React, { Component } from 'react';

export default class TaskInput extends Component {
  constructor(props) {
    super(props)

    this.save = this.save.bind(this)
    this.update = this.update.bind(this)
  }


  save(event) {
    if (event.key === 'Enter') {
      this.props.save({
        body: event.target.value
      })

      event.target.value = ''
    }
  }


  update(event) {
    this.props.update(event.target.value.trim())
  }


  render() {
    return (
      <div className="card">
        <div className="card-body">
          <input
            className="form-control"
            placeholder="Add task and press"
            value={this.props.value}
            onKeyPress={this.save}
            onChange={this.update}
            autoFocus={true}
          />
        </div>
      </div>
    );
  }
}
